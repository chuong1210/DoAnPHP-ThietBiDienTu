@extends('client.layouts.client')

@section('title', 'Đặt hàng thành công')

@section('styles')
<style>
    :root {
        --primary: #0066FF;
        --secondary: #00B4D8;
        --bg: #F8FAFC;
        --text: #1E293B;
        --neutral: #CBD5E1;
        --success: #10B981;
        --danger: #EF4444;
    }

    .order-success-page {
        background: linear-gradient(135deg, #f8f9ff 0%, var(--bg) 100%);
        min-height: 100vh;
        padding: 3rem 0;
    }

    .success-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 35px rgba(16, 185, 129, 0.3);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .success-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }

    .success-subtitle {
        color: #64748B;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-home {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.2);
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 102, 255, 0.3);
        color: white;
    }

    .order-card {
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--neutral);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .order-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .order-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .order-date {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }

    .table-modern {
        margin: 0;
    }

    .table-modern th {
        background: #f1f5f9;
        color: var(--text);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
    }

    .table-modern td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--neutral);
    }

    .table-modern tbody tr:hover {
        background: #f8faff;
    }

    .price-original {
        text-decoration: line-through;
        color: #94A3B8;
        font-size: 0.9rem;
    }

    .price-sale {
        color: var(--danger);
        font-weight: 700;
    }

    .total-row {
        font-size: 1.1rem;
        font-weight: 600;
        background: #f8f9ff !important;
    }

    .total-row td {
        padding: 1.25rem 1rem;
        border: none;
    }

    .total-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--danger);
    }

    .info-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--neutral);
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px dashed var(--neutral);
    }

    .info-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .info-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .info-content h6 {
        margin: 0 0 0.5rem;
        color: var(--text);
        font-weight: 600;
    }

    .info-content p {
        margin: 0;
        color: #64748B;
        line-height: 1.5;
    }

    .badge-coupon {
        background: linear-gradient(135deg, #f093fb, #f5576c);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .success-title { font-size: 2rem; }
        .order-number { font-size: 1.3rem; }
        .table-modern { font-size: 0.9rem; }
        .info-item { flex-direction: column; }
        .info-icon { width: 40px; height: 40px; font-size: 1rem; }
    }
</style>
@endsection

@section('content')
<div class="order-success-page">
    <div class="container">
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="success-title">{{ __('info.order_successful') }}</h1>
            <p class="success-subtitle">
                Cảm ơn bạn đã tin tưởng! Đơn hàng của bạn đã được tiếp nhận.
            </p>
            <a href="{{ route('client.home.index') }}" class="btn-home">
                <i class="fas fa-home"></i>
                {{ __('info.explore_more_products') }}
            </a>
        </div>

        <!-- Order Summary Card -->
        <div class="order-card">
            <div class="order-header">
                <h2 class="order-number">
                    {{ __('info.order_title') }} #{{ $order->order_number }}
                </h2>
                <p class="order-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ convertDateTime($order->created_at) }}
                </p>
            </div>

            <div class="card-body p-0">
                <table class="table table-modern w-100">
                    <thead>
                        <tr>
                            <th>{{ __('info.product_name') }}</th>
                            <th class="text-center">{{ __('info.quantity') }}</th>
                            <th class="text-end">{{ __('info.selling_price') }}</th>
                            <th class="text-end">{{ __('info.money') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach ($order->items as $item)
                            @php $subtotal += $item->price * $item->quantity; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset($item->product_image) }}"
                                             alt="{{ $item->product_name }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <div>
                                            <strong>{{ $item->product_name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">
                                    {{ formatCurrency($item->price) }}
                                </td>
                                <td class="text-end fw-bold text-primary">
                                    {{ formatCurrency($item->price * $item->quantity) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($order->coupon_id)
                            <tr>
                                <td colspan="3" class="text-end">
                                    {{ __('info.discount_code') }}
                                    <span class="badge-coupon ms-2">
                                        <i class="fas fa-tag"></i>
                                        {{ $order->coupon->code ?? '' }}
                                    </span>
                                </td>
                                <td class="text-end text-success fw-bold">
                                    - {{ formatCurrency($order->discount) }}
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td colspan="3" class="text-end">{{ __('info.total_product_value') }}</td>
                            <td class="text-end">{{ formatCurrency($subtotal) }}</td>
                        </tr>

                        <tr>
                            <td colspan="3" class="text-end">{{ __('info.shipping_fee') }}</td>
                            <td class="text-end">{{ formatCurrency($order->shipping_fee) }}</td>
                        </tr>

                        <tr class="total-row">
                            <td colspan="3" class="text-end">
                                <strong class="h5 mb-0">{{ __('info.total payment') }}</strong>
                            </td>
                            <td class="text-end">
                                <strong class="total-price">{{ formatCurrency($order->total) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Delivery & Payment Info -->
        <div class="info-card">
            <h4 class="mb-4 fw-bold text-text">
                <i class="fas fa-truck me-2 text-primary"></i>
                {{ __('info.delivery_information_payment') }}
            </h4>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="info-content">
                    <h6>{{ __('info.recipient_name') }}</h6>
                    <p>{{ $order->customer_name }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="info-content">
                    <h6>{{ __('info.email') }}</h6>
                    <p>{{ $order->customer_email ?? 'Không có' }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="info-content">
                    <h6>{{ __('info.address') }}</h6>
                    <p>
                        {{ $order->shipping_address }}<br>
                        <strong>{{ $order->shipping_ward }}</strong>,
                        <em>{{ $order->province_name ?? 'Tỉnh/TP' }}</em>
                    </p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="info-content">
                    <h6>{{ __('info.phone') }}</h6>
                    <p>{{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="info-content">
                    <h6>{{ __('info.payment_method') }}</h6>
                    <p>
                        <span class="badge bg-primary">
                            {{ array_column(__('payment.method'), 'title', 'name')[$order->payment_method] ?? $order->payment_method }}
                        </span>
                    </p>
                </div>
            </div>

            @if($order->note)
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <div class="info-content">
                        <h6>Ghi chú</h6>
                        <p>{{ $order->note }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Optional Template -->
        @if (isset($template))
            @include($template)
        @endif
    </div>
</div>
@endsection
