<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Sử dụng Model trực tiếp hoặc qua Repository đều được
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hiển thị danh sách đơn hàng với bộ lọc và thống kê.
     */
    public function index(Request $request)
    {
        // Bắt đầu câu truy vấn
        $query = Order::query()->with('user')->orderBy('created_at', 'desc');

        // 1. Lọc theo từ khóa (mã đơn, tên khách, sđt)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('order_number', 'LIKE', "%{$keyword}%")
                    ->orWhere('customer_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('customer_phone', 'LIKE', "%{$keyword}%");
            });
        }

        // 2. Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // 3. Lọc theo ngày (từ ngày... đến nay)
        if ($request->filled('date_from')) {
            try {
                $dateFrom = Carbon::parse($request->input('date_from'))->startOfDay();
                $query->where('created_at', '>=', $dateFrom);
            } catch (\Exception $e) {
                // Bỏ qua nếu ngày không hợp lệ
            }
        }

        // Phân trang
        $orders = $query->paginate(15)->withQueryString();

        // Lấy dữ liệu cho các thẻ thống kê
        $stats = [
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'shipping_orders' => Order::where('status', 'shipping')->count(),
            'monthly_revenue' => Order::where('payment_status', 'paid')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified resource.
     * Hiển thị chi tiết một đơn hàng.
     */
    public function show(string $id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     * (Chúng ta sẽ không dùng hàm này, thay vào đó dùng updateStatus cho rõ ràng)
     * Tuy nhiên, route resource có thể trỏ đến đây, nên ta sẽ điều hướng nó.
     */
    public function update(Request $request, string $id)
    {
        // Điều hướng đến phương thức updateStatus chuyên dụng
        return $this->updateStatus($request, $id);
    }

    /**
     * Cập nhật trạng thái của một đơn hàng.
     * Đây là phương thức tùy chỉnh, được gọi từ form trong trang show.
     */
    public function updateStatus(Request $request, string $id)
    {
        // 1. Validate dữ liệu đầu vào
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,delivered,cancelled',
        ], [
            'status.required' => 'Vui lòng chọn một trạng thái.',
            'status.in'       => 'Trạng thái được chọn không hợp lệ.',
        ]);

        // 2. Tìm đơn hàng
        $order = Order::findOrFail($id);

        // (Tùy chọn) Logic kiểm tra chuyển đổi trạng thái hợp lệ
        // Ví dụ: Không cho phép chuyển từ 'delivered' về 'pending'
        // if ($order->status === 'delivered' && $validated['status'] === 'pending') {
        //     return back()->with('error', 'Không thể chuyển trạng thái từ "Đã giao" về "Chờ xử lý".');
        // }

        // 3. Cập nhật trạng thái
        $order->status = $validated['status'];

        // Tự động cập nhật trạng thái thanh toán nếu đơn hàng được giao thành công và là COD
        if ($validated['status'] === 'delivered' && $order->payment_method === 'cod') {
            $order->payment_status = 'paid';
        }

        // (Tùy chọn) Xử lý hoàn lại số lượng sản phẩm nếu đơn hàng bị hủy
        if ($validated['status'] === 'cancelled') {
            $order->payment_status = 'failed'; // Hoặc 'refunded' nếu đã thanh toán
            foreach ($order->items as $item) {
                $item->product()->increment('quantity', $item->quantity);
            }
        }

        $order->save();

        // (Tùy chọn) Gửi email thông báo cho khách hàng về việc cập nhật trạng thái
        // try {
        //     Mail::to($order->customer_email)->send(new OrderStatusUpdatedMail($order));
        // } catch (\Exception $e) {
        //     // Ghi log nếu gửi mail lỗi nhưng không làm gián đoạn quy trình
        //     Log::error("Failed to send order status update email for order {$order->id}: " . $e->getMessage());
        // }

        // 4. Chuyển hướng về trang chi tiết với thông báo thành công
        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function showInvoice(string $id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Load view 'invoice' và truyền dữ liệu đơn hàng vào
        $pdf = Pdf::loadView('admin.orders.invoice', compact('order'));

        // Hiển thị PDF trong trình duyệt (không tự động tải về)
        return $pdf->stream('hoa_don_' . $order->order_number . '.pdf');
    }
    /**
     * Các phương thức create, store, edit, destroy thường không cần thiết
     * cho việc quản lý đơn hàng từ phía admin.
     */
    public function create()
    {
        abort(404);
    }
    public function store(Request $request)
    {
        abort(404);
    }
    public function edit(string $id)
    {
        abort(404);
    }
    public function destroy(string $id)
    {
        abort(404);
    }
}
