@extends('client.layouts.client')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Success Message -->
                <div class="card shadow-lg border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle"
                                style="width: 100px; height: 100px;">
                                <i class="fas fa-check fa-3x text-white"></i>
                            </div>
                        </div>

                        <h2 class="text-success mb-3">Đặt Hàng Thành Công!</h2>
                        <p class="text-muted mb-4">
                            Cảm ơn bạn đã đặt hàng tại Shop Điện Tử.<br>
                            Đơn hàng của bạn đang được xử lý.
                        </p>

                        <div class="alert alert-info">
                            <strong>Mã đơn hàng:</strong>
                            <span class="h5 text-primary">{{ $order->order_number }}</span>
                        </div>

                        <!-- Order Info -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <div class="row text-start">
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-user"></i> Người nhận:</strong>
                                        <p class="mb-0">{{ $order->customer_name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-phone"></i> Số điện thoại:</strong>
                                        <p class="mb-0">{{ $order->customer_phone }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <strong><i class="fas fa-map-marker-alt"></i> Địa chỉ:</strong>
                                        <p class="mb-0">{{ $order->shipping_address }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-credit-card"></i> Thanh toán:</strong>
                                        <p class="mb-0">
                                            @if($order->payment_method === 'cod')
                                                Thanh toán khi nhận hàng (COD)
                                            @elseif($order->payment_method === 'bank_transfer')
                                                Chuyển khoản ngân hàng
                                            @else
                                                Ví MoMo
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong><i class="fas fa-dollar-sign"></i> Tổng tiền:</strong>
                                        <p class="mb-0 h5 text-danger">{{ number_format($order->total) }}đ</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Chi Tiết Đơn Hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->price) }}đ</td>
                                                    <td>{{ number_format($item->subtotal) }}đ</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                                <td><strong>{{ number_format($order->subtotal) }}đ</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                                <td><strong>{{ number_format($order->shipping_fee) }}đ</strong></td>
                                            </tr>
                                            @if($order->discount > 0)
                                                <tr class="text-success">
                                                    <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                                    <td><strong>-{{ number_format($order->discount) }}đ</strong></td>
                                                </tr>
                                            @endif
                                            <tr class="table-active">
                                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                                <td><strong
                                                        class="text-danger h5">{{ number_format($order->total) }}đ</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('client.my-orders.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-list"></i> Xem Đơn Hàng Của Tôi
                            </a>
                            <a href="{{ route('client.home.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-home"></i> Về Trang Chủ
                            </a>
                        </div>

                        <!-- Next Steps -->
                        <div class="alert alert-warning mt-4 text-start">
                            <h6><i class="fas fa-info-circle"></i> Bước tiếp theo:</h6>
                            <ol class="mb-0">
                                <li>Chúng tôi sẽ xác nhận đơn hàng của bạn trong 1-2 giờ</li>
                                <li>Đơn hàng sẽ được giao trong 2-3 ngày làm việc</li>
                                <li>Bạn có thể theo dõi trạng thái đơn hàng tại mục "Đơn Hàng Của Tôi"</li>
                                @if($order->payment_method === 'bank_transfer')
                                    <li class="text-danger">
                                        <strong>Lưu ý:</strong> Vui lòng chuyển khoản trong vòng 24h để giữ đơn hàng
                                    </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection