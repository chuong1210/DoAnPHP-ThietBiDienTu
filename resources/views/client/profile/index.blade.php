@extends('client.layouts.client')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Hồ Sơ Cá Nhân</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Hồ Sơ Cá Nhân
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab">
                                <i class="fas fa-user-edit me-1"></i> Thông Tin Cá Nhân
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                                type="button" role="tab">
                                <i class="fas fa-lock me-1"></i> Đổi Mật Khẩu
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label fw-bold">Họ và Tên <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                            id="full_name" name="full_name"
                                            value="{{ old('full_name', Auth::user()->full_name) }}" required>
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                            readonly>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold">Số Điện Thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                        placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('client.home.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Hủy
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Cập Nhật
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form action="{{ route('profile.update.password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-bold">Mật Khẩu Hiện Tại <span
                                            class="text-danger">*</span></label>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">Mật Khẩu Mới <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" required minlength="8">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label fw-bold">Xác Nhận Mật Khẩu Mới
                                            <span class="text-danger">*</span></label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i> Hủy
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-2"></i> Đổi Mật Khẩu
                                    </button>
                                </div>
                            </form>
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
                            <a href="{{ route('client.my-orders.index') }}" class="btn btn-outline-primary btn-sm">Xem Đơn
                                Hàng</a>
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