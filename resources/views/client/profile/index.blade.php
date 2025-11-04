@extends('client.layouts.client')

@section('title', 'Hồ Sơ Cá Nhân')
@php
    $hideSidebar = true;
@endphp
@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb modern-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home.index') }}"><i class="fas fa-home"></i> Trang chủ</a>
            </li>
            <li class="breadcrumb-item active">Hồ Sơ Cá Nhân</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <div class="avatar-circle">
                        {{ substr(Auth::user()->full_name, 0, 2) }}
                    </div>
                </div>
                <div class="profile-info">
                    <h2>{{ Auth::user()->full_name }}</h2>
                    <p>{{ Auth::user()->email }}</p>
                    <div class="profile-badges">
                        @if(Auth::user()->role === 'admin')
                            <span class="badge-role admin">
                                <i class="fas fa-crown"></i> Quản trị viên
                            </span>
                        @else
                            <span class="badge-role user">
                                <i class="fas fa-user"></i> Khách hàng
                            </span>
                        @endif
                        <span class="badge-status">
                            <i class="fas fa-check-circle"></i> Đã xác thực
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="profile-card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-user-circle me-2"></i>
                        Quản Lý Tài Khoản
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Tabs Nav -->
                    <ul class="nav nav-tabs modern-tabs mb-4" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab">
                                <i class="fas fa-user-edit"></i>
                                <span>Thông Tin Cá Nhân</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                                type="button" role="tab">
                                <i class="fas fa-lock"></i>
                                <span>Đổi Mật Khẩu</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            <form action="{{ route('profile.update') }}" method="POST" class="modern-form">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="full_name" class="form-label">
                                            <i class="fas fa-user me-1"></i> Họ và Tên <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                                id="full_name" name="full_name"
                                                value="{{ old('full_name', Auth::user()->full_name) }}" required>
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i> Email <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                                required readonly>
                                            <div class="input-note">
                                                <i class="fas fa-lock"></i> Email không thể thay đổi
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-1"></i> Số Điện Thoại
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                            placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-actions">
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
                            <form action="{{ route('profile.update.password') }}" method="POST" class="modern-form">
                                @csrf
                                <div class="mb-4">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-key me-1"></i> Mật Khẩu Hiện Tại <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="password" class="form-label">
                                            <i class="fas fa-lock me-1"></i> Mật Khẩu Mới <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password" required minlength="8">
                                            <div class="input-note">
                                                <i class="fas fa-info-circle"></i> Tối thiểu 8 ký tự
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            <i class="fas fa-shield-alt me-1"></i> Xác Nhận Mật Khẩu Mới <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="password_confirmation" name="password_confirmation" required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
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
            <div class="quick-links-section">
                <h4 class="section-title">
                    <i class="fas fa-bolt me-2"></i> Truy Cập Nhanh
                </h4>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="quick-link-card orders">
                            <div class="card-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="card-content">
                                <h5>Đơn Hàng</h5>
                                <p>Theo dõi đơn hàng của bạn</p>
                            </div>
                            <a href="{{ route('client.my-orders.index') }}" class="card-link">
                                Xem Ngay <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quick-link-card reviews">
                            <div class="card-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="card-content">
                                <h5>Đánh Giá</h5>
                                <p>Quản lý đánh giá sản phẩm</p>
                            </div>
                            <a href="{{ route('profile.reviews') }}" class="card-link">
                                Xem Ngay <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quick-link-card cart">
                            <div class="card-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="card-content">
                                <h5>Giỏ Hàng</h5>
                                <p>Sản phẩm đang chờ thanh toán</p>
                            </div>
                            <a href="{{ route('client.cart.index') }}" class="card-link">
                                Xem Ngay <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
    }

    /* Breadcrumb */
    .modern-breadcrumb {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        border: 2px solid var(--neutral);
    }

    .modern-breadcrumb a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .modern-breadcrumb a:hover {
        color: var(--secondary);
    }

    .modern-breadcrumb .active {
        color: #64748B;
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 24px;
        padding: 3rem;
        margin-bottom: 2rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 2rem;
        box-shadow: 0 10px 40px rgba(0, 102, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .profile-avatar {
        position: relative;
        z-index: 2;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .profile-info {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .profile-info h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .profile-info p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin-bottom: 1rem;
    }

    .profile-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .badge-role,
    .badge-status {
        padding: 0.65rem 1.25rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(10px);
    }

    .badge-role.admin {
        background: rgba(251, 191, 36, 0.3);
        border: 2px solid rgba(251, 191, 36, 0.5);
    }

    .badge-role.user {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .badge-status {
        background: rgba(16, 185, 129, 0.3);
        border: 2px solid rgba(16, 185, 129, 0.5);
    }

    /* Profile Card */
    .profile-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 2px solid var(--neutral);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .profile-card .card-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 1.75rem 2rem;
        border: none;
    }

    .profile-card .card-header h4 {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .profile-card .card-body {
        padding: 2.5rem;
    }

    /* Modern Tabs */
    .modern-tabs {
        border: none;
        display: flex;
        gap: 0.5rem;
        background: var(--background);
        padding: 0.5rem;
        border-radius: 16px;
    }

    .modern-tabs .nav-link {
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        color: var(--text);
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-tabs .nav-link i {
        font-size: 1.1rem;
    }

    .modern-tabs .nav-link:hover {
        background: white;
        color: var(--primary);
    }

    .modern-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    /* Modern Form */
    .modern-form .form-label {
        color: var(--text);
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .modern-form .form-label i {
        color: var(--primary);
    }

    .input-wrapper {
        position: relative;
    }

    .modern-form .form-control {
        border: 2px solid var(--neutral);
        border-radius: 12px;
        padding: 0.85rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .modern-form .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
    }

    .modern-form .form-control:read-only {
        background: var(--background);
        cursor: not-allowed;
    }

    .input-note {
        font-size: 0.85rem;
        color: #64748B;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .form-actions .btn {
        padding: 0.85rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .form-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
    }

    .form-actions .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
    }

    .form-actions .btn-secondary {
        background: var(--background);
        border: 2px solid var(--neutral);
        color: var(--text);
    }

    .form-actions .btn-secondary:hover {
        border-color: var(--primary);
        background: white;
    }

    /* Quick Links */
    .quick-links-section {
        margin-top: 3rem;
    }

    .section-title {
        color: var(--text);
        font-weight: 800;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--primary);
    }

    .quick-link-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 2px solid var(--neutral);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    .quick-link-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.3s ease;
    }

    .quick-link-card.orders::before {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .quick-link-card.reviews::before {
        background: linear-gradient(135deg, #F59E0B, #F97316);
    }

    .quick-link-card.cart::before {
        background: linear-gradient(135deg, #10B981, #059669);
    }

    .quick-link-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 102, 255, 0.15);
    }

    .quick-link-card:hover::before {
        transform: scale(1.2);
        opacity: 0.15;
    }

    .quick-link-card.orders:hover {
        border-color: var(--primary);
    }

    .quick-link-card.reviews:hover {
        border-color: #F59E0B;
    }

    .quick-link-card.cart:hover {
        border-color: #10B981;
    }

    .card-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .quick-link-card.orders .card-icon {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .quick-link-card.reviews .card-icon {
        background: linear-gradient(135deg, #F59E0B, #F97316);
    }

    .quick-link-card.cart .card-icon {
        background: linear-gradient(135deg, #10B981, #059669);
    }

    .card-icon i {
        font-size: 2rem;
        color: white;
    }

    .card-content {
        flex: 1;
        position: relative;
        z-index: 2;
    }

    .card-content h5 {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .card-content p {
        color: #64748B;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .card-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .quick-link-card.reviews .card-link {
        color: #F59E0B;
    }

    .quick-link-card.cart .card-link {
        color: #10B981;
    }

    .card-link:hover {
        transform: translateX(4px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
            padding: 2rem;
        }

        .profile-info h2 {
            font-size: 2rem;
        }

        .profile-badges {
            justify-content: center;
        }

        .profile-card .card-body {
            padding: 1.5rem;
        }

        .modern-tabs {
            flex-direction: column;
        }

        .modern-tabs .nav-link {
            justify-content: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>