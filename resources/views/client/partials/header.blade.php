<header class="bg-white shadow-sm sticky-top" style="border-bottom: 1px solid #E2E8F0;">
    <div class="container-fluid">
        <!-- Top Header -->
        <div class="row py-2 align-items-center"> <!-- Giảm py-3 → py-2 -->
            <!-- Logo -->
            <div class="col-md-3 col-6">
                <a href="{{ route('client.home.index') }}" class="text-decoration-none d-flex align-items-center">
                    <div class="logo-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <div class="ms-2">
                        <h4 class="mb-0 fw-bold logo-text">Tech Shop</h4>
                        <small class="text-muted d-none d-md-block" style="font-size: 0.65rem;">Innovation &
                            Quality</small>
                    </div>
                </a>
            </div>

            <!-- Search Box -->
            <div class="col-md-6 col-12 my-2 my-md-0">
                <form action="{{ route('client.search') }}" method="GET" class="search-wrapper">
                    <div class="input-group modern-search">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm, thương hiệu..."
                            value="{{ request('q') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search me-1 d-none d-sm-inline"></i> Tìm
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Actions -->
            <div class="col-md-3 col-6 text-end d-flex align-items-center justify-content-end h-100"> @auth
                <!-- User Dropdown -->
                <div class="dropdown d-inline me-2">
                    <button class="btn btn-user dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="avatar-circle">
                            {{ substr(Auth::user()->full_name, 0, 1) }}
                        </div>
                        <span class="d-none d-md-inline ms-2">{{ Str::limit(Auth::user()->full_name, 10) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end modern-dropdown">
                        <li class="dropdown-header">
                            <strong class="d-block text-truncate"
                                style="max-width: 220px;">{{ Auth::user()->full_name }}</strong>
                            <div class="text-muted small text-truncate" style="max-width: 220px;">
                                {{ Auth::user()->email }}
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt text-primary"></i> Bảng Điều Khiển
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item" href="{{ route('client.profile.index') }}">
                                <i class="fas fa-user-circle text-info"></i> Hồ Sơ
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('client.my-orders.index') }}">
                                <i class="fas fa-box text-warning"></i> Đơn Hàng
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-1">
                        <i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline">Đăng Nhập</span>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> <span class="d-none d-md-inline">Đăng Ký</span>
                    </a>
                @endauth

                <!-- Cart Icon -->
                <a href="{{ route('client.cart.index') }}" class="btn btn-cart position-relative ms-2">
                    <i class="fas fa-shopping-cart"></i>
                    @auth
                        @php $cartItemsCount = Auth::user()->cart?->items->sum('quantity') ?? 0; @endphp
                        @if($cartItemsCount > 0)
                            <span class="cart-badge">{{ $cartItemsCount > 99 ? '99+' : $cartItemsCount }}</span>
                        @endif
                    @endauth
                </a>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light py-0 border-top" style="border-color: #E2E8F0 !important;">
            <div class="container-fluid px-0">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto gap-1"> <!-- Thêm gap -->
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link {{ request()->routeIs('client.home.index') ? 'active' : '' }}"
                                href="{{ route('client.home.index') }}">
                                <i class="fas fa-home"></i>
                                <span>Trang Chủ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link {{ request()->routeIs('client.products.*') ? 'active' : '' }}"
                                href="{{ route('client.product.index') }}">
                                <i class="fas fa-box-open"></i>
                                <span>Sản Phẩm</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link" href="#">
                                <i class="fas fa-fire"></i>
                                <span>Khuyến Mãi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link modern-nav-link {{ request()->routeIs('client.support.index') ? 'active' : '' }}"
                                href="{{ route('client.support.index') }}"> <i class="fas fa-headset"></i>
                                <span>Hỗ Trợ</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<style>
    :root {
        --primary: #0066FF;
        --secondary: #00B4D8;
        --background: #F8FAFC;
        --text: #1E293B;
        --neutral: #E2E8F0;
    }

    /* Logo */
    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(0, 102, 255, 0.15);
    }

    .logo-icon i {
        color: white;
        font-size: 1.3rem;
    }

    .logo-text {
        color: var(--text);
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.35rem;
    }

    /* Search */
    .modern-search {
        height: 48px;
        /* Đã có */
        display: flex;
        align-items: center;
    }

    .modern-search:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.12);
    }

    .modern-search .input-group-text {
        background: transparent;
        border: none;
        color: #94A3B8;
        padding-left: 1rem;
    }

    .modern-search .form-control {
        border: none;
        padding: 0.5rem 0.75rem;
        font-size: 0.93rem;
        height: 100%;
    }

    .modern-search .form-control:focus {
        box-shadow: none;
    }

    .modern-search .btn-primary {
        border-radius: 0 50px 50px 0;
        padding: 0.5rem 1.3rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* User Button */
    .btn-user {
        background: var(--background);
        border: 1.5px solid var(--neutral);
        border-radius: 50px;
        padding: 0.35rem 0.65rem;
        color: var(--text);
        font-weight: 600;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .btn-user:hover {
        border-color: var(--primary);
        background: white;
        transform: translateY(-1px);
    }

    .avatar-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Dropdown */
    .modern-dropdown {
        border-radius: 14px;
        border: 1.5px solid var(--neutral);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        padding: 0.4rem;
        min-width: 240px;
        margin-top: 0.4rem;
        font-size: 0.9rem;
    }

    .modern-dropdown .dropdown-header {
        padding: 0.6rem 0.9rem;
        background: var(--background);
        border-radius: 10px;
        margin-bottom: 0.4rem;
    }

    .modern-dropdown .dropdown-item {
        border-radius: 8px;
        padding: 0.55rem 0.9rem;
        transition: background 0.2s ease;
        font-size: 0.9rem;
    }

    .modern-dropdown .dropdown-item i {
        width: 18px;
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    /* QUAN TRỌNG: Chỉ hover mới dịch, không dịch khi focus/active */
    .modern-dropdown .dropdown-item:hover {
        background: var(--background);
        transform: translateX(3px);
    }

    /* Không dịch khi active/focus */
    .modern-dropdown .dropdown-item:active,
    .modern-dropdown .dropdown-item:focus {
        transform: none !important;
        background: var(--background);
    }

    /* Cart */
    .btn-cart {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--background);
        border: 1.5px solid var(--neutral);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--text);
        transition: all 0.25s ease;
        font-size: 1.1rem;
    }

    .btn-cart:hover {
        border-color: var(--primary);
        background: white;
        color: var(--primary);
        transform: translateY(-1px);
    }

    .cart-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        font-weight: 700;
        border: 2px solid white;
    }

    /* Nav Links */
    .modern-nav-link {
        padding: 0.7rem 1.2rem;
        color: var(--text);
        font-weight: 500;
        transition: all 0.25s ease;
        border-radius: 12px;
        margin: 0 0.15rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.95rem;
    }

    .modern-nav-link i {
        font-size: 0.95rem;
        transition: transform 0.3s ease;
    }

    .modern-nav-link:hover {
        background: var(--background);
        color: var(--primary);
    }

    .modern-nav-link:hover i {
        transform: scale(1.15);
    }

    .modern-nav-link.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 3px 10px rgba(0, 102, 255, 0.25);
    }

    .modern-nav-link.active i {
        animation: pulse 1.8s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }
    }

    /* Buttons */
    .btn-primary,
    .btn-outline-primary {
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.45rem 1rem;
        transition: all 0.25s ease;
    }

    .btn-primary:hover,
    .btn-outline-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);
    }


    /* CỰC KỲ QUAN TRỌNG: Căn giữa dropdown & cart với search */
    .user-cart-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        height: 100%;
    }

    .btn-user,
    .btn-cart {
        height: 42px;
        /* Đều chiều cao */
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>