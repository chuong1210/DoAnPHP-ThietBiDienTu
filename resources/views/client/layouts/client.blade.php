<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Chủ') - Shop Điện Tử</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .product-card {
            transition: transform 0.2s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
        }

        .category-sidebar {
            background: white;
            border-radius: 8px;
            padding: 20px;
        }

        .category-item {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-item a {
            color: #333;
            text-decoration: none;
        }

        .category-item a:hover {
            color: #007bff;
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Header -->
    @include('client.partials.header')

    <!-- Main Content -->
    <main class="py-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Category (nếu có) -->
                @if(!isset($hideSidebar))
                    <div class="col-md-3">
                        @include('client.partials.sidebar-category')
                    </div>
                    <div class="col-md-9">
                        @yield('content')
                    </div>
                @else
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('client.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>