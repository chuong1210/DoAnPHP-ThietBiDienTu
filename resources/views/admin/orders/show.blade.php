@extends('admin.layouts.admin')

@section('title', 'Chi Tiết Đơn Hàng: ' . $order->order_number)
@section('page-title', 'Chi Tiết Đơn Hàng')

@section('styles')
    <style>
        .order-header {
            background-color: var(--background);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--neutral);
        }

        .order-details-list {
            list-style: none;
            padding: 0;
        }

        .order-details-list li {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--neutral);
        }

        .order-details-list li:last-child {
            border-bottom: none;
        }

        .order-details-list li .label {
            width: 150px;
            font-weight: 600;
            color: #64748B;
            flex-shrink: 0;
        }

        .order-details-list li .value {
            font-weight: 500;
            color: var(--text);
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-item-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            border: 1px solid var(--neutral);
        }

        .product-item-info a {
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
        }

        .product-item-info a:hover {
            color: var(--primary);
        }

        .order-summary-card {
            position: sticky;
            top: 20px;
        }

        .price-breakdown .row {
            padding: 0.5rem 0;
        }

        /* Badge Trạng thái (sao chép từ index) */
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
            border-radius: 20px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-badge-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-badge-confirmed {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-badge-shipping {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-badge-delivered {
            background-color: #E0E7FF;
            color: #3730A3;
        }

        .status-badge-cancelled {
            background-color: #FEE2E2;
            color: #991B1B;
        }
    </style>
@endsection

@section('content')
    <!-- Header: Order ID & Date -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Đơn hàng <span class="text-primary">{{ $order->order_number }}</span></h1>
            <small class="text-muted">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</small>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
        </a>
    </div>

    <div class="row">
        <!-- Cột trái: Thông tin chi tiết -->
        <div class="col-lg-8">
            <!-- Thông tin khách hàng -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i> Thông Tin Khách Hàng</h5>
                </div>
                <div class="card-body">
                    <ul class="order-details-list">
                        <li>
                            <div class="label">Tên Khách Hàng</div>
                            <div class="value">{{ $order->customer_name }}</div>
                        </li>
                        <li>
                            <div class="label">Email</div>
                            <div class="value">{{ $order->customer_email ?? 'N/A' }}</div>
                        </li>
                        <li>
                            <div class="label">Số Điện Thoại</div>
                            <div class="value">{{ $order->customer_phone }}</div>
                        </li>
                        <li>
                            <div class="label">Địa Chỉ Giao Hàng</div>
                            <div class="value">{{ $order->shipping_address }}</div>
                        </li>
                        @if($order->note)
                            <li>
                                <div class="label">Ghi Chú</div>
                                <div class="value fst-italic">{{ $order->note }}</div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-box-open me-2"></i> Sản Phẩm Trong Đơn</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="product-item {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <img src="{{ asset($item->product_image ?? 'https://via.placeholder.com/100') }}"
                                class="product-item-img" alt="{{ $item->product_name }}">
                            <div class="product-item-info grow">
                                <a href="{{ route('client.product.show', $item->product->slug) }}" target="_blank">
                                    {{ $item->product_name }}
                                </a>
                                <div class="text-muted small">Đơn giá: {{ number_format($item->price) }}đ</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ number_format($item->subtotal) }}đ</div>
                                <div class="text-muted small">x {{ $item->quantity }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cột phải: Tổng quan & Hành động -->
        <div class="col-lg-4">
            <div class="order-summary-card">
                <!-- Tổng quan giá -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Tổng Quan Đơn Hàng</h5>
                    </div>
                    <div class="card-body price-breakdown">
                        <div class="row">
                            <div class="col">Tạm tính:</div>
                            <div class="col text-end">{{ number_format($order->subtotal) }}đ</div>
                        </div>
                        <div class="row">
                            <div class="col">Phí vận chuyển:</div>
                            <div class="col text-end">{{ number_format($order->shipping_fee) }}đ</div>
                        </div>
                        <div class="row text-danger">
                            <div class="col">Giảm giá:</div>
                            <div class="col text-end">-{{ number_format($order->discount) }}đ</div>
                        </div>
                        <hr>
                        <div class="row fw-bold h5">
                            <div class="col">Tổng Cộng:</div>
                            <div class="col text-end text-primary">{{ number_format($order->total) }}đ</div>
                        </div>
                    </div>
                </div>

                <!-- Cập nhật trạng thái -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cập Nhật Trạng Thái</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="fw-bold me-2">Trạng thái hiện tại:</span>
                            <span class="status-badge status-badge-{{ $order->status }}">{{ $order->status }}</span>
                        </div>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-bold">Thay đổi trạng thái:</label>
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                    </option>
                                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác
                                        nhận</option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao
                                        hàng</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao
                                        thành công</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn
                                        hàng</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Cập Nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection