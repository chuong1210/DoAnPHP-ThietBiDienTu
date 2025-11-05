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
    // app/Http/Controllers/Admin/OrderController.php

    public function updateStatus(Request $request, string $id)
    {
        // 1. Validate dữ liệu đầu vào (giữ nguyên)
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,delivered,cancelled',
        ]);

        // 2. Tìm đơn hàng
        $order = Order::findOrFail($id);

        // === THÊM LỚP BẢO MẬT VÀO ĐÂY ===
        if ($order->status === 'delivered' || $order->status === 'cancelled') {
            return back()->with('error', 'Không thể cập nhật trạng thái cho đơn hàng đã hoàn thành hoặc đã bị hủy.');
        }
        // ===================================

        // (Tùy chọn) Logic kiểm tra chuyển đổi trạng thái hợp lệ
        // Ví dụ: Không cho phép chuyển từ 'shipping' về 'pending'
        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['shipping', 'cancelled'],
            'shipping' => ['delivered', 'cancelled'],
        ];

        if (isset($allowedTransitions[$order->status]) && !in_array($validated['status'], $allowedTransitions[$order->status])) {
            return back()->with('error', "Không thể chuyển từ trạng thái '{$order->status}' sang '{$validated['status']}'.");
        }


        // 3. Cập nhật trạng thái (giữ nguyên)
        $order->status = $validated['status'];

        // ... logic cập nhật payment_status và hoàn kho giữ nguyên ...
        if ($validated['status'] === 'delivered' && $order->payment_method === 'cod') {
            $order->payment_status = 'paid';
        }
        if ($validated['status'] === 'cancelled') {
            $order->payment_status = 'failed';
            foreach ($order->items as $item) {
                // Chỉ hoàn kho nếu sản phẩm còn tồn tại
                if ($item->product) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }
        }

        $order->save();

        // ...
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
