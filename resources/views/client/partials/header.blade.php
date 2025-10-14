<header class="bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Top Header -->
        <div class="row py-3 border-bottom align-items-center">
            <!-- Logo -->
            <div class="col-md-3 col-6">
                <a href="{{ route('client.home.index') }}"
                    class="h4 text-decoration-none text-primary fw-bold d-flex align-items-center">
                    <i class="fas fa-shopping-bag me-2 text-primary"></i> Shop Điện Tử
                </a>
            </div>

            <!-- Search Box -->
            <div class="col-md-6 col-12">
                <form action="{{ route('client.search') }}" method="GET" class="d-flex">
                    <input type="text" name="q" class="form-control me-2 rounded-pill px-4"
                        placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}"
                        style="border: 1px solid #dee2e6;">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">
                        <i class="fas fa-search"></i> Tìm Kiếm
                    </button>
                </form>
            </div>

            <!-- User Actions -->
            <div class="col-md-3 col-6 text-end">
                @auth
                    <!-- User Dropdown -->
                    <div class="dropdown d-inline me-2">
                        <button class="btn btn-outline-primary dropdown-toggle rounded-pill px-3" type="button"
                            id="userMenu" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="fas fa-user me-1"></i> {{ Str::limit(Auth::user()->full_name, 15) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-start shadow-sm" style="min-width: 200px;">
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Bảng Điều Khiển
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user-circle me-2"></i> Hồ Sơ Cá Nhân
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('client.my-orders.index') }}">
                                    <i class="fas fa-box me-2"></i> Đơn Hàng Của Tôi
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                        <i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Guest Links -->
                    <div class="d-inline-block">
                        <a href="{{ route('auth.login') }}" class="btn btn-outline-primary btn-sm rounded-pill me-2 px-3">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
                        </a>
                        <a href="{{ route('auth.register') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fas fa-user-plus me-1"></i> Đăng Ký
                        </a>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <a href="{{ route('client.cart.index') }}"
                    class="btn btn-outline-secondary position-relative rounded-pill px-3">
                    <i class="fas fa-shopping-cart"></i>
                    @auth
                        @php $cartItemsCount = Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0; @endphp
                        @if($cartItemsCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartItemsCount }}
                                <span class="visually-hidden">số lượng sản phẩm trong giỏ</span>
                            </span>
                        @endif
                    @endauth
                </a>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light py-2">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav gap-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('client.home.index') ? 'active text-primary fw-bold' : '' }} rounded-pill px-3 py-2"
                                href="{{ route('client.home.index') }}">
                                <i class="fas fa-home me-1"></i> Trang Chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('client.products.*') ? 'active text-primary fw-bold' : '' }} rounded-pill px-3 py-2"
                                href="{{ route('client.product.index') }}">
                                <i class="fas fa-box me-1"></i> Sản Phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link rounded-pill px-3 py-2"
                                href="{{ route('client.profile.reviews') }}">
                                <i class="fas fa-fire me-1"></i> Khuyến Mãi
                            </a> --}}
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link rounded-pill px-3 py-2" href="{{ route('client.profile.review') }}">
                                <i class="fas fa-phone me-1"></i> Liên Hệ
                            </a> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<style>
    .nav-link:hover {
        background-color: #f8f9fa;
        color: #0d6efd !important;
    }

    .nav-link.active {
        color: #0d6efd !important;
        border: 1px solid #0d6efd;
    }

    .dropdown-menu {
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        border-radius: 5px;
    }
</style>