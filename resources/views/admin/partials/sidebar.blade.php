{{-- resources/views/admin/partials/sidebar.blade.php --}}

<div class="sidebar">
    <!-- Brand with Logo -->
    <div class="brand">
        <div class="d-flex align-items-center justify-content-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2304/2304226.png" alt="Logo" class="brand-logo me-2">
            <h4 class="mb-0 fw-bold">Admin Panel</h4>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav mt-3">
        <!-- Main Section -->
        <div class="nav-section-title" style="font-size: small; color: rgb(4, 146, 233);">
            Tổng Quan
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <!-- Products Section -->
        <div class="nav-section-title" style="font-size: small ; color: rgb(4, 146, 233);">
            Sản Phẩm
        </div>

        <a href="{{ route('admin.products.index') }}"
            class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Quản Lý Sản Phẩm</span>
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-list"></i>
            <span>Quản Lý Danh Mục</span>
        </a>

        <a href="{{ route('admin.brands.index') }}"
            class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i>
            <span>Quản Lý Thương Hiệu</span>
        </a>

        <!-- Orders Section -->
        <div class="nav-section-title" style="font-size: small ; color: rgb(4, 146, 233);">
            Đơn Hàng
        </div>

        <a href="{{ route('admin.orders.index') }}"
            class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Quản Lý Đơn Hàng</span>
            @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                <span class="nav-badge">{{ $pendingOrdersCount }}</span>
            @endif
        </a>

        <!-- Communication Section -->
        <div class="nav-section-title" style="font-size: small ; color: rgb(4, 146, 233);">
            Khách Hàng
        </div>

        <a href="{{ route('admin.chat.index') }}"
            class="nav-link {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>Chat Hỗ Trợ</span>
            @php
                $unreadCount = \App\Models\ChatMessage::whereHas('room', fn($q) => $q->where('status', 'open'))
                    ->where('is_admin', false)->where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="nav-badge">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-user-friends"></i>
            <span>Quản Lý User</span>
        </a>

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Settings Section -->
        <div class="nav-section-title" style="font-size: small ; color: rgb(4, 146, 233);">
            Hệ Thống
        </div>

        <a href="{{ route('admin.banners.index') }}"
            class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i>
            <span>Quản Lý Banners</span>
        </a>

        <a href="{{ route('admin.reviews.index') }}"
            class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i>
            <span>Quản Lý Reviews</span>
        </a>

        <a href="{{ route('admin.contact.index') }}"
            class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="fas fa-headset"></i>
            <span>Quản Lý Contact</span>
        </a>

        <a href="{{ route('admin.faqs.index') }}"
            class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i>
            <span>Quản Lý FAQ</span>
        </a>

        <hr class="bg-secondary opacity-10 mx-3">

        <a href="{{ route('client.home.index') }}" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i>
            <span>Xem Trang Client</span>
            <i class="fas fa-external-link-alt ms-auto" style="font-size: 11px; opacity: 0.6;"></i>
        </a>

        <a href="{{ route('logout') }}" class="nav-link text-danger"
            onclick="event.preventDefault(); if(confirm('Bạn có chắc muốn đăng xuất?')) document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng Xuất</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>
</div>