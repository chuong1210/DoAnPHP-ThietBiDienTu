@extends('client.layouts.client')

@section('title', 'Đơn Hàng Của Tôi')

@section('styles')
    <style>
        .order-card {
            transition: all 0.3s;
            border: 1px solid #e0e0e0;
        }

        .order-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .order-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px 8px 0 0;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .product-mini-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f0f0f0;
        }

        .order-timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline-step {
            position: relative;
            padding-bottom: 30px;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: -29px;
            top: 0;
            width: 2px;
            height: 100%;
            background: #e0e0e0;
        }

        .timeline-step:last-child::before {
            display: none;
        }

        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .timeline-step.active .timeline-icon {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }

        .timeline-step.completed .timeline-icon {
            border-color: #10b981;
            background: #10b981;
            color: white;
        }

        .filter-tabs {
            background: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-tabs .btn {
            border-radius: 8px;
            margin: 0 5px;
            padding: 10px 20px;
            border: none;
            transition: all 0.3s;
        }

        .filter-tabs .btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .price-highlight {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .empty-state {
            padding: 80px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 100px;
            color: #e0e0e0;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">
                            <i class="fas fa-history text-primary"></i> Lịch Sử Đơn Hàng
                        </h2>
                        <p class="text-muted mb-0">Quản lý và theo dõi đơn hàng của bạn</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> In Lịch Sử
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="d-flex flex-wrap justify-content-center">
                <button class="btn {{ !request('status') ? 'active' : '' }}" onclick="filterOrders('all')">
                    <i class="fas fa-list"></i> Tất cả
                    <span class="badge bg-light text-dark ms-1">{{ $orders->total() }}</span>
                </button>
                <button class="btn {{ request('status') == 'pending' ? 'active' : '' }}" onclick="filterOrders('pending')">
                    <i class="fas fa-clock"></i> Chờ xác nhận
                </button>
                <button class="btn {{ request('status') == 'confirmed' ? 'active' : '' }}"
                    onclick="filterOrders('confirmed')">
                    <i class="fas fa-check-circle"></i> Đã xác nhận
                </button>
                <button class="btn {{ request('status') == 'shipping' ? 'active' : '' }}"
                    onclick="filterOrders('shipping')">
                    <i class="fas fa-shipping-fast"></i> Đang giao
                </button>
                <button class="btn {{ request('status') == 'delivered' ? 'active' : '' }}"
                    onclick="filterOrders('delivered')">
                    <i class="fas fa-box"></i> Đã nhận
                </button>
                <button class="btn {{ request('status') == 'cancelled' ? 'active' : '' }}"
                    onclick="filterOrders('cancelled')">
                    <i class="fas fa-times-circle"></i> Đã hủy
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Orders List -->
        @forelse($orders as $order)
            <div class="order-card card mb-4">
                <!-- Order Header -->
                <div class="order-header p-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-receipt fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Đơn hàng #{{ $order->order_number }}</h5>
                                    <small>
                                        <i class="far fa-calendar"></i> {{ $order->created_at->format('d/m/Y H:i') }}
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-box"></i> {{ $order->items->count() }} sản phẩm
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="price-highlight text-white" style="-webkit-text-fill-color: white;">
                                {{ number_format($order->total) }}đ
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Products -->
                        <div class="col-md-7">
                            <h6 class="mb-3">
                                <i class="fas fa-shopping-bag text-primary"></i> Sản phẩm đã đặt
                            </h6>

                            @foreach($order->items->take(3) as $item)
                                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    @if($item->product_image)
                                        <img src="{{ asset('images/products/' . $item->product_image) }}"
                                            alt="{{ $item->product_name }}" class="product-mini-img me-3">
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($item->product_name, 50) }}</h6>
                                        <small class="text-muted">
                                            {{ number_format($item->price) }}đ × {{ $item->quantity }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-primary">{{ number_format($item->subtotal) }}đ</strong>
                                    </div>
                                </div>
                            @endforeach

                            @if($order->items->count() > 3)
                                <div class="text-center">
                                    <a href="{{ route('client.my-orders.show', $order->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus"></i> Xem thêm {{ $order->items->count() - 3 }} sản phẩm
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Status & Actions -->
                        <div class="col-md-5">
                            <!-- Status Badges -->
                            <div class="mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-info-circle text-primary"></i> Trạng thái
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if($order->status === 'pending')
                                        <span class="status-badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i> Chờ xác nhận
                                        </span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="status-badge bg-info text-white">
                                            <i class="fas fa-check-circle"></i> Đã xác nhận
                                        </span>
                                    @elseif($order->status === 'shipping')
                                        <span class="status-badge bg-primary text-white">
                                            <i class="fas fa-shipping-fast"></i> Đang giao hàng
                                        </span>
                                    @elseif($order->status === 'delivered')
                                        <span class="status-badge bg-success text-white">
                                            <i class="fas fa-box"></i> Đã giao hàng
                                        </span>
                                    @else
                                        <span class="status-badge bg-danger text-white">
                                            <i class="fas fa-times-circle"></i> Đã hủy
                                        </span>
                                    @endif

                                    @if($order->payment_status === 'paid')
                                        <span class="status-badge bg-success text-white">
                                            <i class="fas fa-credit-card"></i> Đã thanh toán
                                        </span>
                                    @else
                                        <span class="status-badge bg-secondary text-white">
                                            <i class="fas fa-clock"></i> Chưa thanh toán
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Shipping Info -->
                            <div class="mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary"></i> Địa chỉ giao hàng
                                </h6>
                                <div class="bg-light p-2 rounded">
                                    <strong>{{ $order->customer_name }}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone"></i> {{ $order->customer_phone }}<br>
                                        {{ Str::limit($order->shipping_address, 60) }}
                                    </small>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-3">
                                <h6 class="mb-2">
                                    <i class="fas fa-wallet text-primary"></i> Thanh toán
                                </h6>
                                <div class="bg-light p-2 rounded">
                                    @if($order->payment_method === 'cod')
                                        <i class="fas fa-money-bill-wave text-success"></i> Thanh toán khi nhận hàng
                                    @elseif($order->payment_method === 'bank_transfer')
                                        <i class="fas fa-university text-primary"></i> Chuyển khoản ngân hàng
                                    @else
                                        <i class="fas fa-mobile-alt text-danger"></i> Ví MoMo
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('client.my-orders.show', $order->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Xem Chi Tiết
                                </a>

                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="showCancelModal({{ $order->id }}, '{{ $order->order_number }}')">
                                        <i class="fas fa-times"></i> Hủy Đơn Hàng
                                    </button>
                                @endif

                                @if($order->status === 'delivered')
                                    <button type="button" class="btn btn-outline-success">
                                        <i class="fas fa-star"></i> Đánh Giá
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    @if($order->discount > 0)
                        <div class="alert alert-success mt-3 mb-0">
                            <i class="fas fa-tag"></i> Bạn đã tiết kiệm được
                            <strong>{{ number_format($order->discount) }}đ</strong> từ đơn hàng này
                        </div>
                    @endif
                </div>

                <!-- Quick Timeline -->
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col">
                            <small class="text-muted">Đặt hàng</small><br>
                            <strong>{{ $order->created_at->format('d/m H:i') }}</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted">Xác nhận</small><br>
                            <strong>{{ $order->status !== 'pending' ? '✓' : '⏳' }}</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted">Giao hàng</small><br>
                            <strong>{{ in_array($order->status, ['shipping', 'delivered']) ? '✓' : '⏳' }}</strong>
                        </div>
                        <div class="col">
                            <small class="text-muted">Hoàn thành</small><br>
                            <strong>{{ $order->status === 'delivered' ? '✓' : '⏳' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-shopping-bag"></i>
                <h3 class="mb-3">Chưa Có Đơn Hàng Nào</h3>
                <p class="text-muted mb-4">
                    Hãy khám phá và đặt hàng ngay để trải nghiệm dịch vụ tuyệt vời của chúng tôi
                </p>
                <a href="{{ route('client.product.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Mua Sắm Ngay
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i> Xác Nhận Hủy Đơn Hàng
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="cancelOrderForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p class="mb-3">Bạn có chắc chắn muốn hủy đơn hàng <strong id="cancelOrderNumber"></strong>?</p>

                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            Đơn hàng sẽ được hủy và số lượng sản phẩm sẽ được hoàn lại kho.
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lý do hủy (tùy chọn)</label>
                            <textarea class="form-control" name="cancel_reason" rows="3"
                                placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Đóng
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Xác Nhận Hủy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Filter orders by status
        function filterOrders(status) {
            if (status === 'all') {
                window.location.href = '{{ route("client.my-orders.index") }}';
            } else {
                window.location.href = '{{ route("client.my-orders.index") }}?status=' + status;
            }
        }

        // Show cancel modal
        function showCancelModal(orderId, orderNumber) {
            document.getElementById('cancelOrderNumber').textContent = '#' + orderNumber;
            document.getElementById('cancelOrderForm').action = '/client/my-orders/' + orderId + '/cancel';

            const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        }

        // Auto hide alerts
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection