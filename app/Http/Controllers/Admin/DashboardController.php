<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    // === CÁC HÀM HỖ TRỢ (Đã đúng) ===
    private function getDateRange($period): array
    {
        return match ($period) {
            'today' => [now()->startOfDay(), now()->endOfDay()],
            'last_7_days' => [now()->subDays(6)->startOfDay(), now()->endOfDay()],
            'this_month' => [now()->startOfMonth(), now()->endOfMonth()],
            'this_year' => [now()->startOfYear(), now()->endOfYear()],
            default => [now()->subDays(6)->startOfDay(), now()->endOfDay()], // Mặc định là 7 ngày
        };
    }

    private function getPreviousDateRange($period): array
    {
        return match ($period) {
            'today' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
            'last_7_days' => [now()->subDays(13)->startOfDay(), now()->subDays(7)->endOfDay()],
            'this_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            'this_year' => [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()],
            default => [now()->subDays(13)->startOfDay(), now()->subDays(7)->endOfDay()],
        };
    }

    public function index(Request $request)
    {
        // Lấy khoảng thời gian từ request, mặc định là 'last_7_days'
        $period = $request->input('period', 'last_7_days');

        // === 1. LẤY KHOẢNG THỜI GIAN HIỆN TẠI VÀ TRƯỚC ĐÓ ===
        [$startDate, $endDate] = $this->getDateRange($period);
        [$previousStartDate, $previousEndDate] = $this->getPreviousDateRange($period);

        // === 2. THỐNG KÊ CHO CÁC THẺ (dựa trên bộ lọc) ===
        $revenueCurrentPeriod = Order::where('payment_status', 'paid')->whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $ordersCurrentPeriod = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $revenuePreviousPeriod = Order::where('payment_status', 'paid')->whereBetween('created_at', [$previousStartDate, $previousEndDate])->sum('total');
        $ordersPreviousPeriod = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

        $stats = [
            'revenue' => $revenueCurrentPeriod,
            'revenue_change' => $revenuePreviousPeriod > 0 ? (($revenueCurrentPeriod - $revenuePreviousPeriod) / $revenuePreviousPeriod) * 100 : ($revenueCurrentPeriod > 0 ? 100 : 0),
            'orders' => $ordersCurrentPeriod,
            'orders_change' => $ordersPreviousPeriod > 0 ? (($ordersCurrentPeriod - $ordersPreviousPeriod) / $ordersPreviousPeriod) * 100 : ($ordersCurrentPeriod > 0 ? 100 : 0),
            'new_users' => User::where('role', 'user')->whereBetween('created_at', [$startDate, $endDate])->count(),
            'avg_order_value' => $ordersCurrentPeriod > 0 ? $revenueCurrentPeriod / $ordersCurrentPeriod : 0,
        ];

        // === 3. DỮ LIỆU CHO BIỂU ĐỒ DOANH THU THEO THỜI GIAN (REVENUE TIMELINE) ===
        $dateFormat = ($period == 'this_year') ? '%Y-%m' : '%Y-%m-%d';
        $revenueData = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as date"), DB::raw('SUM(total) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $dateInterval = ($period == 'this_year') ? '1 month' : '1 day';
        $dateRange = CarbonPeriod::create($startDate, $dateInterval, $endDate);

        $chartLabels = [];
        $chartRevenues = [];
        foreach ($dateRange as $date) {
            $formattedDate = $date->format(($period == 'this_year') ? 'Y-m' : 'Y-m-d');
            $labelFormat = ($period == 'this_year') ? 'Tháng ' . $date->month : $date->format('d/m');
            $chartLabels[] = $labelFormat;

            $revenueForDate = $revenueData->firstWhere('date', $formattedDate);
            $chartRevenues[] = $revenueForDate ? (float)$revenueForDate->revenue : 0;
        }
        $revenueTimelineChart = ['labels' => $chartLabels, 'data' => $chartRevenues];


        // === 4. DỮ LIỆU CHO BIỂU ĐỒ DOANH THU THEO THÁNG (CẢ NĂM) ===
        $monthlyRevenueData = Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as revenue'))
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $monthlyChartData = ['labels' => [], 'data' => []];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyChartData['labels'][] = 'T' . $i;
            $monthlyChartData['data'][] = (float)($monthlyRevenueData[$i] ?? 0);
        }

        // === 5. DỮ LIỆU CHO BIỂU ĐỒ TỶ LỆ SẢN PHẨM THEO DANH MỤC ===
        $categoryProductData = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(products.id) as count'))
            ->groupBy('categories.name')
            ->pluck('count', 'name');

        $categoryChartData = [
            'labels' => $categoryProductData->keys()->toArray(),
            'data'   => $categoryProductData->values()->map(fn($val) => (int)$val)->toArray(),
        ];

        // === 6. DỮ LIỆU CHO BIỂU ĐỒ TỶ LỆ TRẠNG THÁI ĐƠN HÀNG ===
        $orderStatusStats = Order::select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // === 7. ĐƠN HÀNG MỚI NHẤT & SẢN PHẨM BÁN CHẠY ===
        $recentOrders = Order::with('user')->orderBy('created_at', 'DESC')->limit(8)->get();
        $topProducts = Product::orderBy('sold_count', 'DESC')->where('sold_count', '>', 0)->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'revenueTimelineChart',
            'monthlyChartData',
            'categoryChartData',
            'orderStatusStats',
            'period'
        ));
    }
}
