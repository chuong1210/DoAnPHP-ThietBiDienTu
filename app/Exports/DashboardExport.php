<?php
// app/Exports/DashboardExport.php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class DashboardExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $period;
    protected $startDate;
    protected $endDate;

    public function __construct($period)
    {
        $this->period = $period;
        [$this->startDate, $this->endDate] = $this->getDateRange($period);
    }

    private function getDateRange($period): array
    {
        return match ($period) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'last_7_days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            'this_month' => [now()->startOfMonth(), now()->endOfMonth()],
            'this_year' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
        };
    }

    public function collection()
    {
        // Lấy stats
        $revenue = Order::where('payment_status', 'paid')->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total');
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $newUsers = \App\Models\User::where('role', 'user')->whereBetween('created_at', [$this->startDate, $this->endOfDay])->count();
        $avgOrder = $orders > 0 ? $revenue / $orders : 0;

        // Recent Orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'DESC')->limit(10)->get();

        // Top Products
        $topProducts = Product::orderBy('sold_count', 'DESC')->where('sold_count', '>', 0)->limit(10)->get();

        // Order Status Stats
        $orderStatusStats = Order::select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Revenue Timeline (group by day/month)
        $dateFormat = ($this->period == 'this_year') ? '%Y-%m' : '%Y-%m-%d';
        $revenueTimeline = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as date"), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Collection cho Excel (multi-sheet ngầm qua headings)
        $collection = collect();

        // Sheet 1: Summary Stats
        $collection->push(['=== THỐNG KÊ TỔNG QUAN ===', '', '', '']);
        $collection->push(['Khoảng thời gian', $this->period, '', '']);
        $collection->push(['Doanh Thu', number_format($revenue) . 'đ', '', '']);
        $collection->push(['Số Đơn Hàng', $orders, '', '']);
        $collection->push(['Khách Hàng Mới', $newUsers, '', '']);
        $collection->push(['Giá Trị Đơn TB', number_format($avgOrder) . 'đ', '', '']);
        $collection->push(['', '', '', '']); // Spacer

        // Sheet 2: Recent Orders
        $collection->push(['=== ĐƠN HÀNG MỚI NHẤT ===', '', '', '']);
        $collection->push(['Mã ĐH', 'Khách Hàng', 'Tổng Tiền', 'Trạng Thái', 'Ngày Tạo']);
        foreach ($recentOrders as $order) {
            $collection->push([
                $order->order_number,
                $order->customer_name ?? $order->user->full_name,
                number_format($order->total) . 'đ',
                ucfirst($order->status),
                $order->created_at->format('d/m/Y H:i')
            ]);
        }
        $collection->push(['', '', '', '', '']); // Spacer

        // Sheet 3: Top Products
        $collection->push(['=== SẢN PHẨM BÁN CHẠY ===', '', '', '']);
        $collection->push(['Tên Sản Phẩm', 'Giá', 'Số Lượng Bán', 'Danh Mục']);
        foreach ($topProducts as $product) {
            $collection->push([
                $product->name,
                number_format($product->price) . 'đ',
                $product->sold_count,
                $product->category->name ?? 'N/A'
            ]);
        }
        $collection->push(['', '', '', '']); // Spacer

        // Sheet 4: Order Status
        $collection->push(['=== TRẠNG THÁI ĐƠN HÀNG ===', '', '', '']);
        $collection->push(['Trạng Thái', 'Số Lượng']);
        foreach ($orderStatusStats as $status => $count) {
            $collection->push([ucfirst($status), $count]);
        }
        $collection->push(['', '', '', '']); // Spacer

        // Sheet 5: Revenue Timeline
        $collection->push(['=== DOANH THU THEO THỜI GIAN ===', '', '', '']);
        $collection->push(['Ngày/Tháng', 'Doanh Thu']);
        foreach ($revenueTimeline as $item) {
            $collection->push([$item->date, number_format($item->revenue) . 'đ']);
        }

        return $collection;
    }

    public function headings(): array
    {
        return []; // Headings được handle trong collection
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style cho headers (bold, blue background)
            1 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0066FF']]],
            7 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '0066FF']]],
            13 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '0066FF']]],
            20 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '0066FF']]],
            25 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '0066FF']]],
            // Align center cho all
        ] + array_fill_keys(range(1, 30), ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
    }

    public function title(): string
    {
        return 'Dashboard_Stats_' . $this->period . '_' . now()->format('Y-m-d');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 20,
        ];
    }
}
