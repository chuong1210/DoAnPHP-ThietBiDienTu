@extends('client.layouts.client')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_number)
@php
    $hideSidebar = true;
@endphp
@section('styles')
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg: #F8FAFC;
            --text: #1E293B;
            --neutral: #E2E8F0;
        }

        .order-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2.5rem 0;
            border-radius: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .order-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><path d="M0,10 Q25,0 50,10 T100,10 L100,20 L0,20 Z" fill="rgba(255,255,255,0.1)"/></svg>') repeat-x bottom;
            background-size: 100px 20px;
            opacity: 0.3;
        }

        .info-card {
            border: 1.5px solid var(--neutral);
            border-radius: 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
        }

        .info-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        .info-card .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 1.25rem 1.25rem 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 1.25rem;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary), var(--neutral));
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            padding: 1.5rem 0 2rem 3rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 1.5rem;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: white;
            border: 4px solid var(--neutral);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #94A3B8;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .timeline-item.active .timeline-icon,
        .timeline-item.completed .timeline-icon {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            animation: pulse 2s infinite;
        }

        .timeline-item.completed .timeline-icon {
            background: var(--success);
            border-color: var(--success);
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

        .timeline-content {
            background: var(--bg);
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            border-left: 4px solid var(--primary);
        }

        .timeline-item.completed .timeline-content {
            border-left-color: var(--success);
        }

        /* Product Item */
        .product-item {
            border: 2px solid var(--neutral);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .product-item:hover {
            border-color: var(--primary);
            box-shadow: 0 6px 20px rgba(0, 102, 255, 0.15);
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--neutral);
        }

        /* Summary */
        .summary-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
        }

        .summary-card .total {
            font-size: 2.8rem;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            letter-spacing: -1px;
        }

        /* Action Buttons */
        .action-btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-cancel {
            background: var(--danger);
            color: white;
        }

        .btn-contact {
            background: var(--warning);
            color: white;
        }

        /* Print */
        .print-section {
            display: none;
        }

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
                display: block;
            }

            .no-print,
            .action-btn,
            header,
            footer {
                display: none !important;
            }

            .container {
                max-width: 100% !important;
            }

            .info-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="order-header position-relative">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="mb-2 fw-bold">
                            <i class="fas fa-receipt me-2"></i> Chi Tiết Đơn Hàng
                        </h2>
                        <h3 class="mb-3 text-white">#{{ $order->order_number }}</h3>
                        <p class="mb-0 d-flex flex-wrap gap-3 align-items-center">
                            <span><i class="far fa-calendar-alt me-1"></i>
                                {{ $order->created_at->format('d/m/Y H:i') }}</span>
                            <span><i class="fas fa-box me-1"></i> {{ $order->items->count() }} sản phẩm</span>
                            <span><i class="fas fa-credit-card me-1"></i> {{ ucfirst($order->payment_method) }}</span>
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <div>
                            <small class="d-block opacity-75">Tổng thanh toán</small>
                            <h1 class="mb-0 fw-bold">{{ number_format($order->total) }}đ</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4 no-print d-flex flex-wrap gap-2">
            <a href="{{ route('client.my-orders.index') }}" class="btn btn-outline-primary action-btn">
                <i class="fas fa-arrow-left me-1"></i> Quay Lại
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary action-btn">
                <i class="fas fa-print me-1"></i> In Đơn
            </button>
            @if($order->canCancel())
                <form action="{{ route('client.my-orders.cancel', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-cancel action-btn"
                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng?')">
                        <i class="fas fa-times me-1"></i> Hủy Đơn
                    </button>
                </form>
            @endif
            <a href="{{ route('client.support.index') }}" class="btn btn-contact action-btn">
                <i class="fas fa-headset me-1"></i> Liên Hệ
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print rounded-3">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left: Timeline + Products -->
            <div class="col-lg-8">
                <!-- Timeline -->
                <div class="info-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-shipping-fast me-2"></i> Tiến Trình Giao Hàng
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <!-- Đặt hàng -->
                            <div class="timeline-item completed">
                                <div class="timeline-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Đơn hàng đã đặt</h6>
                                    <p class="text-muted small mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Xác nhận -->
                            <div
                                class="timeline-item {{ in_array($order->status, ['confirmed', 'shipping', 'delivered']) ? 'completed' : '' }} {{ $order->status === 'confirmed' ? 'active' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Đã xác nhận</h6>
                                    <p class="text-muted small mb-0">
                                        {{ in_array($order->status, ['confirmed', 'shipping', 'delivered']) ? $order->updated_at->format('d/m/Y H:i') : 'Chờ xác nhận...' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Đang giao -->
                            <div
                                class="timeline-item {{ in_array($order->status, ['shipping', 'delivered']) ? 'completed' : '' }} {{ $order->status === 'shipping' ? 'active' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Đang giao hàng</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $order->status === 'shipping' || $order->status === 'delivered' ? $order->updated_at->format('d/m/Y H:i') : 'Chờ vận chuyển...' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Hoàn thành -->
                            <div
                                class="timeline-item {{ $order->status === 'delivered' ? 'completed' : '' }} {{ $order->status === 'delivered' ? 'active' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Giao hàng thành công</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $order->status === 'delivered' ? $order->updated_at->format('d/m/Y H:i') : 'Chưa giao...' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sản phẩm -->
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-box-open me-2"></i> Sản Phẩm Trong Đơn
                    </div>
                    <div class="card-body p-4">
                        @foreach($order->items as $item)
                            <div class="product-item d-flex align-items-center">
                                <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}"
                                    class="product-img me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $item->product_name }}</h6>
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>SL: {{ $item->quantity }}</span>
                                        <span>Giá: {{ number_format($item->price) }}đ</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <strong class="text-primary">{{ number_format($item->subtotal) }}đ</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Summary + Info -->
            <div class="col-lg-4">
                <!-- Tổng tiền -->
                <div class="summary-card mb-4">
                    <h5 class="mb-3 opacity-90">Tổng Thanh Toán</h5>
                    <div class="total">{{ number_format($order->total) }}đ</div>
                    <small class="d-block mt-2 opacity-75">
                        @if($order->discount > 0) Đã giảm {{ number_format($order->discount) }}đ @endif
                    </small>
                </div>

                <!-- Thông tin giao hàng -->
                <div class="info-card mb-4">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt me-2"></i> Địa Chỉ Giao Hàng
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>{{ $order->customer_name }}</strong></p>
                        <p class="mb-2"><i class="fas fa-phone me-1"></i> {{ $order->customer_phone }}</p>
                        @if($order->customer_email)
                            <p class="mb-2"><i class="fas fa-envelope me-1"></i> {{ $order->customer_email }}</p>
                        @endif
                        <p class="mb-0 text-muted">
                            {{ $order->shipping_address }}
                            @if($order->shipping_ward), {{ $order->shipping_ward }} @endif
                            @if($order->shipping_city), {{ $order->shipping_city }} @endif
                        </p>
                    </div>
                </div>

                <!-- Thanh toán -->
                <div class="info-card">
                    <div class="card-header">
                        <i class="fas fa-credit-card me-2"></i> Thông Tin Thanh Toán
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tạm tính:</span>
                            <strong>{{ number_format($order->subtotal) }}đ</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Phí vận chuyển:</span>
                            <strong>{{ number_format($order->shipping_fee) }}đ</strong>
                        </div>
                        @if($order->discount > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Giảm giá:</span>
                                <strong>-{{ number_format($order->discount) }}đ</strong>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-danger fs-5">{{ number_format($order->total) }}đ</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Version -->
    <div class="print-section container mt-5">
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
@endsection