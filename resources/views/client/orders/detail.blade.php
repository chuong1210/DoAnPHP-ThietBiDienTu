@extends('client.layouts.client')
@php
    $hideSidebar = true;
@endphp
@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_number)

@section('content')
    <div class="container py-4">
        <!-- Order Header -->
        <div class="order-detail-header">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="header-badge">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h2 class="header-title">Chi Tiết Đơn Hàng</h2>
                        <h3 class="header-number">#{{ $order->order_number }}</h3>
                        <div class="header-meta">
                            <span><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d/m/Y H:i') }}</span>
                            <span><i class="fas fa-box"></i> {{ $order->items->count() }} sản phẩm</span>
                            <span><i class="fas fa-credit-card"></i>
                                @if($order->payment_method === 'cod')
                                    COD
                                @elseif($order->payment_method === 'bank_transfer')
                                    Chuyển khoản
                                @else
                                    MoMo
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <div class="header-total-wrapper">
                            <small class="total-label">Tổng thanh toán</small>
                            <h1 class="total-amount">{{ number_format($order->total) }}đ</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-bar no-print">
            <a href="{{ route('client.my-orders.index') }}" class="btn-action back">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
            <button onclick="window.print()" class="btn-action print">
                <i class="fas fa-print"></i> In Đơn
            </button>
            @if($order->canCancel())
                <form action="{{ route('client.my-orders.cancel', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action cancel" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng?')">
                        <i class="fas fa-times"></i> Hủy Đơn
                    </button>
                </form>
            @endif
            <a href="#" class="btn-action contact">
                <i class="fas fa-headset"></i> Liên Hệ
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-modern success no-print">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Timeline + Products -->
            <div class="col-lg-8">
                <!-- Timeline -->
                <div class="timeline-card">
                    <div class="card-header-modern">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Tiến Trình Giao Hàng</span>
                    </div>
                    <div class="card-body-modern">
                        <div class="timeline-container">
                            <!-- Step 1: Order Placed -->
                            <div class="timeline-step completed">
                                <div class="step-indicator">
                                    <div class="step-circle">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="step-line"></div>
                                </div>
                                <div class="step-content">
                                    <h6 class="step-title">Đơn hàng đã đặt</h6>
                                    <p class="step-time">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="step-description">Đơn hàng đã được tạo thành công</p>
                                </div>
                            </div>

                            <!-- Step 2: Confirmed -->
                            <div
                                class="timeline-step {{ in_array($order->status, ['confirmed', 'shipping', 'delivered']) ? 'completed' : '' }} {{ $order->status === 'confirmed' ? 'active' : '' }}">
                                <div class="step-indicator">
                                    <div class="step-circle">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <div class="step-line"></div>
                                </div>
                                <div class="step-content">
                                    <h6 class="step-title">Đã xác nhận</h6>
                                    <p class="step-time">
                                        {{ in_array($order->status, ['confirmed', 'shipping', 'delivered']) ? $order->updated_at->format('d/m/Y H:i') : 'Chờ xác nhận...' }}
                                    </p>
                                    <p class="step-description">Đơn hàng đã được xác nhận và chuẩn bị</p>
                                </div>
                            </div>

                            <!-- Step 3: Shipping -->
                            <div
                                class="timeline-step {{ in_array($order->status, ['shipping', 'delivered']) ? 'completed' : '' }} {{ $order->status === 'shipping' ? 'active' : '' }}">
                                <div class="step-indicator">
                                    <div class="step-circle">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="step-line"></div>
                                </div>
                                <div class="step-content">
                                    <h6 class="step-title">Đang giao hàng</h6>
                                    <p class="step-time">
                                        {{ $order->status === 'shipping' || $order->status === 'delivered' ? $order->updated_at->format('d/m/Y H:i') : 'Chờ vận chuyển...' }}
                                    </p>
                                    <p class="step-description">Đơn hàng đang được vận chuyển đến bạn</p>
                                </div>
                            </div>

                            <!-- Step 4: Delivered -->
                            <div
                                class="timeline-step {{ $order->status === 'delivered' ? 'completed' : '' }} {{ $order->status === 'delivered' ? 'active' : '' }}">
                                <div class="step-indicator">
                                    <div class="step-circle">
                                        <i class="fas fa-gift"></i>
                                    </div>
                                </div>
                                <div class="step-content">
                                    <h6 class="step-title">Giao hàng thành công</h6>
                                    <p class="step-time">
                                        {{ $order->status === 'delivered' ? $order->updated_at->format('d/m/Y H:i') : 'Chưa giao...' }}
                                    </p>
                                    <p class="step-description">Đơn hàng đã được giao thành công</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <div class="products-card">
                    <div class="card-header-modern">
                        <i class="fas fa-box-open"></i>
                        <span>Sản Phẩm Trong Đơn</span>
                    </div>
                    <div class="card-body-modern">
                        <div class="products-list">
                            @foreach($order->items as $item)
                                <div class="product-item-detail">
                                    <div class="product-image-wrapper">
                                        @if($item->product_image)
                                            <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}">
                                        @else
                                            <div class="image-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-info-wrapper">
                                        <h6 class="product-name">{{ $item->product_name }}</h6>
                                        <div class="product-meta">
                                            <span class="quantity">Số lượng: {{ $item->quantity }}</span>
                                            <span class="price">Đơn giá: {{ number_format($item->price) }}đ</span>
                                        </div>
                                    </div>
                                    <div class="product-total">
                                        {{ number_format($item->subtotal) }}đ
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary + Info -->
            <div class="col-lg-4">
                <!-- Total Summary -->
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h5 class="summary-title">Tổng Thanh Toán</h5>
                    <div class="summary-amount">{{ number_format($order->total) }}đ</div>
                    @if($order->discount > 0)
                        <small class="summary-note">Đã tiết kiệm {{ number_format($order->discount) }}đ</small>
                    @endif
                </div>

                <!-- Shipping Address -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa Chỉ Giao Hàng</span>
                    </div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <strong>{{ $order->customer_name }}</strong>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-phone"></i>
                            <span>{{ $order->customer_phone }}</span>
                        </div>
                        @if($order->customer_email)
                            <div class="info-row">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $order->customer_email }}</span>
                            </div>
                        @endif
                        <div class="info-row address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>
                                {{ $order->shipping_address }}
                                @if($order->shipping_ward), {{ $order->shipping_ward }}@endif
                                @if($order->shipping_city), {{ $order->shipping_city }}@endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="info-card">
                    <div class="info-card-header">
                        <i class="fas fa-credit-card"></i>
                        <span>Chi Tiết Thanh Toán</span>
                    </div>
                    <div class="info-card-body">
                        <div class="payment-row">
                            <span>Tạm tính:</span>
                            <strong>{{ number_format($order->subtotal) }}đ</strong>
                        </div>
                        <div class="payment-row">
                            <span>Phí vận chuyển:</span>
                            <strong>{{ number_format($order->shipping_fee) }}đ</strong>
                        </div>
                        @if($order->discount > 0)
                            <div class="payment-row discount">
                                <span>Giảm giá:</span>
                                <strong>-{{ number_format($order->discount) }}đ</strong>
                            </div>
                        @endif
                        <div class="payment-divider"></div>
                        <div class="payment-row total">
                            <span>Tổng cộng:</span>
                            <strong>{{ number_format($order->total) }}đ</strong>
                        </div>
                        <div class="payment-method">
                            <i class="fas fa-info-circle"></i>
                            Phương thức:
                            @if($order->payment_method === 'cod')
                                <strong>Thanh toán khi nhận hàng</strong>
                            @elseif($order->payment_method === 'bank_transfer')
                                <strong>Chuyển khoản ngân hàng</strong>
                            @else
                                <strong>Ví MoMo</strong>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Status Badge -->
                <div class="status-badge-card">
                    @if($order->status === 'pending')
                        <div class="status-badge-large warning">
                            <i class="fas fa-clock"></i>
                            <span>Chờ xác nhận</span>
                        </div>
                    @elseif($order->status === 'confirmed')
                        <div class="status-badge-large info">
                            <i class="fas fa-check-circle"></i>
                            <span>Đã xác nhận</span>
                        </div>
                    @elseif($order->status === 'shipping')
                        <div class="status-badge-large primary">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Đang giao hàng</span>
                        </div>
                    @elseif($order->status === 'delivered')
                        <div class="status-badge-large success">
                            <i class="fas fa-check-double"></i>
                            <span>Đã giao hàng</span>
                        </div>
                    @else
                        <div class="status-badge-large danger">
                            <i class="fas fa-times-circle"></i>
                            <span>Đã hủy</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Print Version -->
    <div class="print-section" style="display: none;">
        <div class="container mt-5">
            <div class="text-center mb-4">
                <h3>TECH SHOP - HÓA ĐƠN</h3>
                <p>#{{ $order->order_number }} | {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>SL</th>
                        <th>Giá</th>
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
                </tbody>
            </table>
            <p class="text-end"><strong>Tổng: {{ number_format($order->total) }}đ</strong></p>
            <p>Giao đến: {{ $order->shipping_address }}</p>
        </div>
    </div>
@endsection

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

    /* Order Header */
    .order-detail-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2.5rem 0;
        border-radius: 24px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 102, 255, 0.3);
    }

    .order-detail-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .header-badge {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .header-badge i {
        font-size: 2rem;
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        opacity: 0.95;
    }

    .header-number {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .header-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        font-size: 0.95rem;
        opacity: 0.95;
    }

    .header-meta span {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-total-wrapper {
        text-align: right;
    }

    .total-label {
        display: block;
        opacity: 0.9;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .total-amount {
        font-size: 2.75rem;
        font-weight: 800;
        line-height: 1;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Action Buttons Bar */
    .action-buttons-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .btn-action {
        padding: 0.85rem 1.75rem;
        border-radius: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        border: 2px solid var(--neutral);
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-action.back {
        background: white;
        color: var(--text);
    }

    .btn-action.back:hover {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }

    .btn-action.print {
        background: white;
        color: var(--text);
        border-color: var(--neutral);
    }

    .btn-action.print:hover {
        background: #64748B;
        border-color: #64748B;
        color: white;
    }

    .btn-action.cancel {
        background: white;
        color: var(--danger);
        border-color: var(--danger);
    }

    .btn-action.cancel:hover {
        background: var(--danger);
        color: white;
    }

    .btn-action.contact {
        background: var(--warning);
        color: white;
        border-color: var(--warning);
    }

    .btn-action.contact:hover {
        background: #F97316;
        border-color: #F97316;
    }

    /* Alert Modern */
    .alert-modern {
        border-radius: 16px;
        border: none;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .alert-modern.success {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .alert-modern i {
        font-size: 1.5rem;
    }

    /* Card Styles */
    .timeline-card,
    .products-card,
    .info-card {
        background: white;
        border-radius: 20px;
        border: 2px solid var(--neutral);
        margin-bottom: 2rem;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .card-header-modern {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .card-header-modern i {
        font-size: 1.25rem;
    }

    .card-body-modern {
        padding: 2rem;
    }

    /* Timeline */
    .timeline-container {
        display: flex;
        flex-direction: column;
    }

    .timeline-step {
        display: flex;
        gap: 1.5rem;
        padding-bottom: 2rem;
    }

    .timeline-step:last-child {
        padding-bottom: 0;
    }

    .step-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        border: 4px solid var(--neutral);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94A3B8;
        font-size: 1.25rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .timeline-step.completed .step-circle,
    .timeline-step.active .step-circle {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .timeline-step.active .step-circle {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .step-line {
        width: 3px;
        flex: 1;
        background: var(--neutral);
        margin-top: 0.5rem;
    }

    .timeline-step:last-child .step-line {
        display: none;
    }

    .timeline-step.completed .step-line {
        background: linear-gradient(to bottom, var(--primary), var(--neutral));
    }

    .step-content {
        flex: 1;
        padding-top: 0.5rem;
    }

    .step-title {
        color: var(--text);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .step-time {
        color: #64748B;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .step-description {
        color: #94A3B8;
        font-size: 0.9rem;
        margin: 0;
    }

    /* Products List */
    .products-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .product-item-detail {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.25rem;
        background: var(--background);
        border-radius: 16px;
        border: 2px solid var(--neutral);
        transition: all 0.3s ease;
    }

    .product-item-detail:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.1);
    }

    .product-image-wrapper {
        width: 90px;
        height: 90px;
        flex-shrink: 0;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid white;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--neutral);
    }

    .product-info-wrapper {
        flex: 1;
    }

    .product-name {
        color: var(--text);
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 0.75rem;
    }

    .product-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        color: #64748B;
        font-size: 0.9rem;
    }

    .product-total {
        color: var(--primary);
        font-weight: 800;
        font-size: 1.35rem;
    }

    /* Summary Card */
    .summary-card {
        background: linear-gradient(135deg, #F093FB, #F5576C);
        color: white;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(240, 147, 251, 0.4);
    }

    .summary-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .summary-icon i {
        font-size: 2rem;
    }

    .summary-title {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 1rem;
    }

    .summary-amount {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.75rem;
        text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .summary-note {
        display: block;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    /* Info Card */
    .info-card-header {
        background: var(--background);
        padding: 1.25rem 1.5rem;
        border-bottom: 2px solid var(--neutral);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
        color: var(--text);
    }

    .info-card-header i {
        color: var(--primary);
        font-size: 1.1rem;
    }

    .info-card-body {
        padding: 1.75rem;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: #64748B;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-row strong {
        color: var(--text);
        font-size: 1.05rem;
    }

    .info-row i {
        color: var(--primary);
        width: 20px;
    }

    .info-row.address {
        align-items: flex-start;
    }

    /* Payment Details */
    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        color: #64748B;
    }

    .payment-row.discount {
        color: var(--success);
    }

    .payment-divider {
        height: 2px;
        background: var(--neutral);
        margin: 1.5rem 0;
    }

    .payment-row.total {
        color: var(--text);
        font-size: 1.1rem;
    }

    .payment-row.total strong {
        color: var(--primary);
        font-size: 1.5rem;
        font-weight: 800;
    }

    .payment-method {
        background: var(--background);
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #64748B;
        font-size: 0.95rem;
    }

    .payment-method i {
        color: var(--primary);
    }

    .payment-method strong {
        color: var(--text);
    }

    /* Status Badge Card */
    .status-badge-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        border: 2px solid var(--neutral);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .status-badge-large {
        padding: 1.5rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        font-weight: 800;
        font-size: 1.25rem;
    }

    .status-badge-large i {
        font-size: 1.75rem;
    }

    .status-badge-large.warning {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
        border: 3px solid #FCD34D;
    }

    .status-badge-large.info {
        background: linear-gradient(135deg, #DBEAFE, #BFDBFE);
        color: #1E40AF;
        border: 3px solid #93C5FD;
    }

    .status-badge-large.primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: 3px solid var(--primary);
        box-shadow: 0 6px 20px rgba(0, 102, 255, 0.3);
    }

    .status-badge-large.success {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
        border: 3px solid #10B981;
    }

    .status-badge-large.danger {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
        border: 3px solid #EF4444;
    }

    /* Print Styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .print-section,
        .print-section * {
            visibility: visible;
        }

        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            display: block !important;
        }

        .no-print {
            display: none !important;
        }

        .order-detail-header,
        .timeline-card,
        .products-card,
        .info-card,
        .summary-card {
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }

    /* Responsive */
    @media (max-width: 992px) {
        .order-detail-header {
            padding: 2rem 1.5rem;
        }

        .header-number {
            font-size: 1.75rem;
        }

        .total-amount {
            font-size: 2rem;
        }

        .card-body-modern {
            padding: 1.5rem;
        }

        .timeline-step {
            gap: 1rem;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .product-item-detail {
            flex-direction: column;
            align-items: flex-start;
        }

        .product-image-wrapper {
            width: 100%;
            height: 200px;
        }

        .product-total {
            align-self: flex-end;
        }
    }

    @media (max-width: 768px) {
        .order-detail-header {
            text-align: center;
        }

        .header-total-wrapper {
            text-align: center;
            margin-top: 1.5rem;
        }

        .header-meta {
            justify-content: center;
        }

        .action-buttons-bar {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .timeline-step {
            gap: 0.75rem;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .step-title {
            font-size: 1rem;
        }

        .product-image-wrapper {
            height: 150px;
        }

        .summary-amount {
            font-size: 2.25rem;
        }

        .info-card-body {
            padding: 1.25rem;
        }
    }
</style>
