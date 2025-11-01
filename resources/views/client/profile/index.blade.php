@extends('client.layouts.home')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Hồ Sơ Cá Nhân</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Menu (Cột Trái) -->
        <div class="col-md-3 profile-sidebar">
            <div class="user-info">
                <div class="d-flex align-items-center mb-3">
                    <div class="user-avatar me-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ Auth::user()->full_name ?? 'Khách Hàng' }}</h5>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="nav nav-pills flex-column" id="profileSidebar" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#profile-info"
                        type="button" role="tab" aria-selected="true">
                        <i class="fas fa-user-edit me-2"></i> Thông tin tài khoản
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="password-tab" data-bs-toggle="pill" data-bs-target="#profile-password"
                        type="button" role="tab" aria-selected="false">
                        <i class="fas fa-lock me-2"></i> Đổi mật khẩu
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#profile-orders"
                        type="button" role="tab" aria-selected="false">
                        <i class="fas fa-box me-2"></i> Quản lý đơn hàng
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('logout') }}" class="nav-link text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content (Cột Phải) -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Hồ Sơ Cá Nhân
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                            @include('auth.profile')
                        </div>

                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="profile-password" role="tabpanel">
                            @include('client.partials.changepassword')
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="profile-orders" role="tabpanel">
                            @include('client.orders.index')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x text-primary mb-3"></i>
                            <h5>Đơn Hàng Của Tôi</h5>
                            <a href="{{ route('client.my-orders.index') }}" class="btn btn-outline-primary btn-sm">Xem
                                Đơn Hàng</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-star fa-3x text-warning mb-3"></i>
                            <h5>Đánh Giá Sản Phẩm</h5>
                            <a href="{{ route('profile.reviews') }}" class="btn btn-outline-primary btn-sm">Xem Đánh
                                Giá</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                            <h5>Giỏ Hàng</h5>
                            <a href="{{ route('client.cart.index') }}" class="btn btn-outline-primary btn-sm">Xem Giỏ
                                Hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
