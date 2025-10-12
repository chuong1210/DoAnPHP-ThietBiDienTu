<header class="bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <!-- Top Header -->
        <div class="row py-2 border-bottom">
            <div class="col-md-3">
                <a href="{{ route('client.home') }}" class="h4 text-decoration-none text-primary">
                    <i class="fas fa-shopping-bag"></i> Shop Điện Tử
                </a>
            </div>

            <!-- Search Box -->
            <div class="col-md-6">
                <form action="{{ route('client.search') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                            value="{{ request('q') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Tìm Kiếm
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Menu -->
            <div class="col-md-3 text-end">
                @auth
                    <div class="dropdown d-inline">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->full_name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Quản Trị
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @endif
                            <li>
                                {{-- <a class="dropdown-item" href="{{ route('client.my-orders') }}">
                                    <i class="fas fa-box"></i> Đơn Hàng Của Tôi
                                </a> --}}
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('auth.login') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                    </a>
                    <a href="{{ route('auth.register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Đăng Ký
                    </a>
                @endauth

                <a href="{{ route('client.cart.index') }}" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-shopping-cart"></i> Giỏ Hàng
                    @auth
                        <span class="badge bg-danger">
                            {{ Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0 }}
                        </span>
                    @endauth
                </a>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('client.home') ? 'active' : '' }}"
                                href="{{ route('client.home') }}">
                                <i class="fas fa-home"></i> Trang Chủ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('client.products.*') ? 'active' : '' }}"
                                href="{{ route('client.product.index') }}">
                                <i class="fas fa-box"></i> Sản Phẩm
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-fire"></i> Khuyến Mãi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-phone"></i> Liên Hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>