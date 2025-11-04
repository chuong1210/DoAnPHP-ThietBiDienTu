@extends('client.layouts.client')

@section('title', 'Đơn Hàng Của Tôi')

@section('styles')
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 102, 255, 0.3);
        }

        .icon-wrapper i {
            font-size: 2rem;
            color: white;
        }

        .header-content h2 {
            color: var(--text);
            font-weight: 800;
            margin: 0;
        }

        .btn-print {
            background: white;
            border: 2px solid var(--neutral);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* Filter Tabs */
        .filter-tabs {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
        }

        .filter-tabs .d-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }

        .filter-tabs .btn {
            background: var(--background);
            border: 2px solid var(--neutral);
            color: var(--text);
            padding: 0.85rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tabs .btn i {
            font-size: 1.1rem;
        }

        .filter-tabs .btn .badge {
            background: var(--neutral);
            color: var(--text);
            padding: 0.25rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .filter-tabs .btn.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-color: transparent;
            box-shadow: 0 6px 16px rgba(0, 102, 255, 0.3);
            transform: translateY(-2px);
        }

        .filter-tabs .btn.active .badge {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .filter-tabs .btn:hover:not(.active) {
            border-color: var(--primary);
            background: white;
            transform: translateY(-2px);
        }

        /* Alerts */
        .alert {
            border-radius: 16px;
            border: none;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert i {
            font-size: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        /* Order Card */
        .order-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--neutral);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-card:hover {
            border-color: var(--primary);
            box-shadow: 0 12px 32px rgba(0, 102, 255, 0.15);
            transform: translateY(-4px);
        }

        .order-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.75rem;
        }

        .order-header .d-flex {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .order-header i.fa-receipt {
            font-size: 2.5rem;
        }

        .order-header h5 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .order-header small {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            opacity: 0.95;
            flex-wrap: wrap;
        }

        .price-highlight {
            font-size: 2rem;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Card Body */
        .order-card .card-body {
            padding: 2rem;
        }

        .order-card h6 {
            color: var(--text);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-card h6 i {
            color: var(--primary);
        }

        /* Product Items */
        .order-card .bg-light {
            background: var(--background) !important;
            border: 2px solid var(--neutral);
            border-radius: 16px;
            padding: 1rem !important;
            transition: all 0.3s ease;
        }

        .order-card .bg-light:hover {
            border-color: var(--primary);
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
        }

        .product-mini-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid white;
        }

        .order-card .bg-light h6 {
            color: var(--text);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.65rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge.bg-warning {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A) !important;
            color: #92400E !important;
        }

        .status-badge.bg-info {
            background: linear-gradient(135deg, #DBEAFE, #BFDBFE) !important;
            color: #1E40AF !important;
        }

        .status-badge.bg-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
            color: white !important;
        }

        .status-badge.bg-success {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0) !important;
            color: #065F46 !important;
        }

        .status-badge.bg-danger {
            background: linear-gradient(135deg, #FEE2E2, #FECACA) !important;
            color: #991B1B !important;
        }

        .status-badge.bg-secondary {
            background: linear-gradient(135deg, #F1F5F9, #E2E8F0) !important;
            color: #475569 !important;
        }

        /* Info Boxes */
        .order-card .card-body>div>div.bg-light {
            background: var(--background) !important;
            border-radius: 16px;
            padding: 1.25rem !important;
            border: 2px solid var(--neutral);
        }

        /* Buttons */
        .order-card .btn {
            padding: 0.85rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .order-card .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .order-card .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
        }

        .order-card .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .order-card .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .order-card .btn-outline-danger {
            border: 2px solid var(--danger);
            color: var(--danger);
            background: transparent;
        }

        .order-card .btn-outline-danger:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
        }

        .order-card .btn-outline-success {
            border: 2px solid var(--success);
            color: var(--success);
            background: transparent;
        }

        .order-card .btn-outline-success:hover {
            background: var(--success);
            color: white;
            transform: translateY(-2px);
        }

        /* Alert Success in Order */
        .order-card .alert-success {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            color: #92400E;
            border: 2px solid #FCD34D;
            margin-top: 1.5rem;
            margin-bottom: 0;
        }

        /* Card Footer */
        .order-card .card-footer {
            background: var(--background) !important;
            padding: 2rem;
            border-top: 2px solid var(--neutral);
        }

        .order-card .card-footer .col {
            padding: 0.5rem;
        }

        .order-card .card-footer small {
            color: #64748B;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .order-card .card-footer strong {
            color: var(--text);
            font-size: 1.1rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 24px;
            border: 2px solid var(--neutral);
        }

        .empty-state i {
            font-size: 6rem;
            color: var(--neutral);
            margin-bottom: 2rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .empty-state .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
            transition: all 0.3s ease;
        }

        .empty-state .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 102, 255, 0.4);
        }

        /* Modal */
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .modal-header.bg-danger {
            background: linear-gradient(135deg, var(--danger), #DC2626) !important;
            border: none;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-body .alert-warning {
            background: linear-gradient(135deg, #FEF3C7, #FDE68A);
            color: #92400E;
            border: 2px solid #FCD34D;
        }

        .modal-body .form-control {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .modal-body .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 2px solid var(--neutral);
        }

        .modal-footer .btn {
            padding: 0.85rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .modal-footer .btn-danger {
            background: var(--danger);
            border: none;
        }

        .modal-footer .btn-danger:hover {
            background: #DC2626;
            transform: translateY(-2px);
        }

        .modal-footer .btn-secondary {
            background: var(--background);
            border: 2px solid var(--neutral);
            color: var(--text);
        }

        .modal-footer .btn-secondary:hover {
            border-color: var(--primary);
            background: white;
        }

        /* Pagination */
        .pagination {
            margin-top: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .filter-tabs .d-flex {
                flex-direction: column;
            }

            .filter-tabs .btn {
                width: 100%;
                justify-content: center;
            }

            .order-header {
                padding: 1.25rem;
            }

            .price-highlight {
                font-size: 1.5rem;
            }

            .order-card .card-body {
                padding: 1.25rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="header-content">
                            <div class="icon-wrapper">
                                <i class="fas fa-history"></i>
                            </div>
                            <div>
                                <h2 class="mb-1">Lịch Sử Đơn Hàng</h2>
                                <p class="text-muted mb-0">Quản lý và theo dõi đơn hàng của bạn</p>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-print" onclick="window.print()">
                                <i class="fas fa-print"></i> In Lịch Sử
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="d-flex flex-wrap justify-content-center">
                <button class="btn {{ !request('status') ? 'active' : '' }}" onclick="filterOrders('all')">
                    <i class="fas fa-list"></i> Tất cả
                    <span class="badge">{{ $orders->total() }}</span>
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
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
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
                            <div class="price-highlight text-white">
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
                                <i class="fas fa-shopping-bag"></i> Sản phẩm đã đặt
                            </h6>

                            @foreach($order->items->take(3) as $item)
                                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                    @if($item->product_image)
                                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}"
                                            class="product-mini-img me-3">
                                    @endif
                                    <div class="grow">
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
                                    <i class="fas fa-info-circle"></i> Trạng thái
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
                                    <i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng
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
                                    <i class="fas fa-wallet"></i> Thanh toán
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
<!-- Thay thế đoạn nút Đánh Giá cũ -->
@if($order->status === 'delivered' && $order->items->where('reviewed', false)->count() > 0)
    <div class="mt-3">
        <h6 class="mb-2">
            <i class="fas fa-star text-warning"></i> Đánh giá sản phẩm
        </h6>
        <div class="d-grid gap-2">
            @foreach($order->items->where('reviewed', false)->take(3) as $item)
                <a href="{{ route('client.reviews.create', $item->product->slug) }}"
                   class="btn btn-outline-success btn-sm">
                    <i class="fas fa-star"></i>
                    Đánh giá: {{ Str::limit($item->product_name, 30) }}
                </a>
            @endforeach

            @if($order->items->where('reviewed', false)->count() > 3)
                <small class="text-muted text-center">
                    Còn {{ $order->items->where('reviewed', false)->count() - 3 }} sản phẩm chưa đánh giá
                </small>
            @endif
        </div>
    </div>
@elseif($order->status === 'delivered')
    <small class="text-success">
        <i class="fas fa-check"></i> Bạn đã đánh giá tất cả sản phẩm
    </small>
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
        <div class="modal-dialog modal-dialog-centered">
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
                            <label class="form-label fw-bold">Lý do hủy (tùy chọn)</label>
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
