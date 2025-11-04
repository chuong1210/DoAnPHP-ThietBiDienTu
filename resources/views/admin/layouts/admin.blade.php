{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Shop Điện Tử</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%);
            --primary-color: #FF3B3F;
            --secondary-color: #FF99AC;
            --bg-main: #FFF5F7;
            --bg-white: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --border-color: #F0D9DE;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
        }

        /* ============================================
           SIDEBAR
        ============================================ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--bg-white);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 3px;
        }

        /* Brand */
        .sidebar .brand {
            padding: 24px 20px;
            background: var(--primary-gradient);
            color: white;
            text-align: center;
            box-shadow: 0 4px 12px rgba(255, 59, 63, 0.2);
        }

        .sidebar .brand h4 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .sidebar .brand i {
            font-size: 24px;
            margin-right: 8px;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-section-title {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-top: 10px;
        }

        .sidebar .nav-link {
            color: var(--text-dark);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin: 2px 0;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 18px;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(90deg, #FFF5F7 0%, transparent 100%);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            border-left-color: #FF1A1E;
            box-shadow: 0 2px 8px rgba(255, 59, 63, 0.2);
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        .sidebar .nav-divider {
            height: 1px;
            background: var(--border-color);
            margin: 16px 20px;
        }

        /* Badge */
        .nav-badge {
            margin-left: auto;
            background: var(--primary-gradient);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(255, 59, 63, 0.3);
        }

        /* ============================================
           MAIN CONTENT
        ============================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: var(--bg-white);
            padding: 20px 30px;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .top-bar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-top {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-primary-gradient {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 59, 63, 0.3);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 59, 63, 0.4);
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 30px;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background: linear-gradient(135deg, #D4F4DD 0%, #ECFDF5 100%);
            color: #065F46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FFE4E6 0%, #FFF1F2 100%);
            color: #BE123C;
        }

        /* Cards */
        .card {
            border-radius: 16px;
            border: 1px solid var(--border-color);
            background: var(--bg-white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            padding: 20px 24px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-body {
            padding: 24px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                padding: 16px 20px;
            }

            .content-wrapper {
                padding: 20px;
            }
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
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
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
