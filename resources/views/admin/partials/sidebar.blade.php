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
            <i class="fas fa-image"></i> Quản Lý Banner
        </a>
        <a href="{{ route('admin.reviews.index') }}"
            class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-image"></i> Quản Lý Reviews
        </a>
        
        <a href="{{ route('admin.contact.index') }}" 
            class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="fas fa-headset"></i> Quản Lý Liên Hệ
        </a>
        <a href="{{ route('admin.faqs.index') }}"
                class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i> Quản Lý Câu Hỏi Thường Gặp
         </a>
        <hr class="bg-secondary">

        <a href="{{ route('client.home.index') }}" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i> Xem Trang Client
        </a>
    </nav>
</div>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Shop Điện Tử</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar .brand {
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            background: #1a252f;
            text-align: center;
        }

        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #34495e;
            border-left-color: #3498db;
            color: white;
        }

        .sidebar .nav-link i {
            width: 25px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background: #ecf0f1;
        }

        .top-bar {
            background: white;
            padding: 15px 20px;
            margin: -20px -20px 20px -20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        @include('admin.partials.header')

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
