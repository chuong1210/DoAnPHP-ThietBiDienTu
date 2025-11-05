<div class="sidebar">
    <div class="brand">
        <i class="fas fa-store"></i> Admin Panel
    </div>

    <nav class="nav flex-column mt-3">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Quản Lý Sản Phẩm
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-list"></i> Quản Lý Danh Mục
        </a>

        <a href="{{ route('admin.brands.index') }}"
            class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <i class="fas fa-tag"></i> Quản Lý Thương Hiệu
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> Quản Lý Đơn Hàng
        </a>

        <a href="{{ route('admin.banners.index') }}"
            class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i> Quản Lý Banners
        </a>

        <a href="{{ route('admin.reviews.index') }}"
            class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-comments"></i> Quản Lý Reviews
        </a>

        <a href="{{ route('admin.contact.index') }}"
            class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="fas fa-headset"></i> Quản Lý Contacts
        </a>

        <a href="{{ route('admin.faqs.index') }}"
            class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i> Quản Lý FAQS
        </a>

        <hr class="bg-secondary">

        <a href="{{ route('client.home.index') }}" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i> Xem Trang Client
        </a>
    </nav>
</div>
