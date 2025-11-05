<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Trang thống kê doanh thu tổng quan
     */
    public function index(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        // Lấy dữ liệu doanh thu & lợi nhuận theo tháng trong năm
        $monthlyRevenue = [];
        $monthlyProfit = [];
        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $start = Carbon::createFromDate($year, $m, 1)->startOfMonth();
            $end = Carbon::createFromDate($year, $m, 1)->endOfMonth();

            $revenue = $this->orderRepository->getRevenueByDateRange($start, $end);

            // Giả lập lợi nhuận = 20% doanh thu (nếu chưa có cột profit)
            $profit = $revenue * 0.2;

            $monthlyRevenue[] = round($revenue, 2);
            $monthlyProfit[] = round($profit, 2);
            $months[] = $start->format('m/Y');
        }

        // Doanh thu, lợi nhuận, đơn hàng trong tháng hiện tại
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
        $thisMonthRevenue = $this->orderRepository->getRevenueByDateRange($thisMonthStart, $thisMonthEnd);
        $thisMonthProfit = $thisMonthRevenue * 0.2; // giả lập
        $thisMonthOrders = \App\Models\Order::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();

        return view('admin.statistics.index', [
            'year' => $year,
            'months' => $months,
            'revenueData' => json_encode($monthlyRevenue),
            'profitData' => json_encode($monthlyProfit),
            'thisMonthRevenue' => $thisMonthRevenue,
            'thisMonthProfit' => $thisMonthProfit,
            'thisMonthOrders' => $thisMonthOrders,
        ]);
    }
}
