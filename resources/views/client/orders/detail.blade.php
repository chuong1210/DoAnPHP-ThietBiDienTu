
@extends('client.layouts.client')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->order_number)

@section('styles')
<style>
    .order-detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        height: 100%;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 30px rgba(0,0,0,0.15);
    }
    .info-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        border: none;
    }
    .timeline-container {
        position: relative;
        padding: 30px 0;
    }
    .timeline-item {
        position: relative;
        padding-left: 80px;
        padding-bottom: 40px;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 27px;
        top: 40px;
        width: 3px;
        height: calc(100% - 40px);
        background: linear-gradient(to bottom, #667eea, #e0e0e0);
    }
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: white;
        border: 4px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #999;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .timeline-item.active .timeline-icon {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        animation: pulse 2s infinite;
    }
    .timeline-item.completed .timeline-icon {
        border-color: #10b981;
        background: #10b981;
        color: white;
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    .product-item {
        border: 2px solid #f0f0f0;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .product-item:hover {
        border-color: #667eea;
        box-shadow: 0 3px 15px rgba(102, 126, 234, 0.2);
    }
    .product-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
    }
    .summary-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 15px;
        padding: 25px;
    }
    .summary-card .total-price {
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    .action-button {
        border-radius: 10px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .print-section {
        display: none;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .print-section, .print-section * {
            visibility: visible;
        }
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            display: block;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="order-detail-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="fas fa-receipt"></i> Chi Tiết Đơn Hàng
                    </h2>
                    <h4 class="mb-3">#{{ $order->order_number }}</h4>
                    <p class="mb-0">
                        <i class="far fa-calendar"></i> Đặt ngày: {{ $order->created_at->format('d/m/Y H:i') }}
                        <span class="mx-3">|</span>
                        <i class="fas fa-box"></i> {{ $order->items->count() }} sản phẩm
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-column">
                        <span class="mb-2">Tổng Thanh Toán</span>
                        <h1 class="mb-0">{{ number_format($order->total) }}đ</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mb-4 no-print">
        <a href="{{ route('client.my-orders') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Quay Lại Danh Sách
        </a>
        <button onclick="window.print()" class="btn btn-outline-secondary">
            <i class="fas fa-print"></i> In Đơn Hàng
        </button>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Timeline -->
            <div class="info-card card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks"></i> Tiến Trình Đơn Hàng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        <div class="timeline-item {{ $order->status === 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Đơn Hàng Đã Đặt</h6>
                                <p class="text-muted mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                <small class="text-muted">Đơn hàng của bạn đã được đặt thành công</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $order->status === 'confirmed' ? 'active' : ($order->status === 'shipping' || $order->status === 'delivered' ? 'completed' : '') }}">
                            <div class="timeline-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Đã Xác Nhận</h6>
                                <p class="text-muted mb-0">
                                    @if(in_array($order->status, ['confirmed', 'shipping', 'delivered']))
                                        {{ $order->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        Đang chờ xác nhận
                                    @endif
                                </p>
                                <small class="text-muted">
                                    @if($order->status === 'confirmed')
                                        Đơn hàng đang được chuẩn bị
                                    @elseif(in_array($order->status, ['shipping', 'delivered']))
