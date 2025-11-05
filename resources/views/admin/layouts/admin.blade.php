{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Shop Điện Tử</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --bg-main: #F8FAFC;
            --bg-card: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --border: #CBD5E1;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --radius: 16px;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            font-size: 14.5px;
            line-height: 1.6;
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
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            z-index: 1030;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 10px;
        }

        /* Brand */
        .brand {
            padding: 20px;
            background: linear-gradient(135deg, var(--primary), #3388FF);
            color: white;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .brand h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.3px;
        }

        /* Nav Section Title */
        .nav-section-title {
            padding: 14px 20px 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .nav-section-title i {
            font-size: 14px;
            opacity: 0.7;
        }

        /* Nav Links */
        .nav-link {
            color: var(--text-dark);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.25s ease;
            border-left: 3px solid transparent;
            margin: 2px 8px;
            border-radius: 10px;
            font-weight: 500;
            position: relative;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 17px;
            color: var(--text-muted);
            transition: all 0.25s ease;
        }

        .nav-link:hover {
            background: rgba(0, 102, 255, 0.08);
            color: var(--primary);
            transform: translateX(4px);
            border-radius: 10px;
        }

        .nav-link:hover i {
            color: var(--primary);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary), #3388FF);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
            border-left-color: #0055CC;
        }

        .nav-link.active i {
            color: white;
        }

        .nav-badge {
            margin-left: auto;
            background: #FF3B30;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 7px;
            border-radius: 50px;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(255, 59, 48, 0.3);
        }

        .nav-divider {
            height: 1px;
            background: var(--border);
            margin: 16px 20px;
            opacity: 0.6;
        }

        /* ============================================
           MAIN CONTENT
        ============================================ */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Bar */
        .top-bar {
            height: var(--topbar-height);
            background: var(--bg-card);
            padding: 0 30px;
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-toggle-sidebar {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-muted);
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-toggle-sidebar:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--primary);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 30px;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* Alerts */
        .alert {
            border-radius: var(--radius);
            border: none;
            padding: 16px 20px;
            margin-bottom: 24px;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
        }

        .alert-success {
            background: linear-gradient(135deg, #D4F4DD 0%, #ECFDF5 100%);
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FFE4E6 0%, #FFF1F2 100%);
            color: #BE123C;
            border-left: 4px solid #EF4444;
        }

        .alert i {
            margin-right: 8px;
            font-size: 18px;
        }

        /* Cards */
        .card {
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--bg-card);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }

        .card-header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 18px 24px;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 16px;
        }

        .card-body {
            padding: 24px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .btn-toggle-sidebar {
                display: block;
            }

            .content-wrapper {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                padding: 0 15px;
            }

            .page-title {
                font-size: 18px;
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
        <header class="top-bar">
            <div class="d-flex align-items-center">
                <button class="btn-toggle-sidebar me-3">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="topbar-actions">
                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-bell"></i>
                </button>
                <img src="https://cdn-icons-png.flaticon.com/512/8188/8188362.png" alt="Admin" class="user-avatar">
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->

    <script>
        // Toggle Sidebar on Mobile
        document.querySelector('.btn-toggle-sidebar').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function (e) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.btn-toggle-sidebar');
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && window.innerWidth <= 992) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>