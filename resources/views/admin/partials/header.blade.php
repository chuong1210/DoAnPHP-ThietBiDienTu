{{-- resources/views/admin/partials/header.blade.php --}}

<div class="top-bar">
    <div class="top-bar-left">
        <h2>@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="top-bar-actions">
        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-bell"></i>
                {{-- Sử dụng biến từ View Composer --}}
                @if(isset($totalNotifications) && $totalNotifications > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $totalNotifications > 9 ? '9+' : $totalNotifications }}
                    </span>
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                <li class="dropdown-header"><strong>Thông Báo</strong></li>
                @if(isset($totalNotifications) && $totalNotifications > 0)
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.chat.index') }}">
                            <i class="fas fa-comment text-danger me-2"></i>
                            <span>{{ $totalNotifications }} tin nhắn mới</span>
                        </a>
                    </li>
                @else
                    <li class="dropdown-item text-muted text-center"><small>Không có thông báo mới</small></li>
                @endif
            </ul>
        </div>

        <!-- User Profile -->
        <div class="dropdown">
            <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle fs-5"></i>
                <span class="d-none d-md-inline">{{ Auth::user()->full_name }}</span>
                <i class="fas fa-chevron-down" style="font-size: 10px;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user me-2"></i> Hồ Sơ
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog me-2"></i> Cài Đặt
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                        onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
                        <i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .top-bar-left h2 {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-light {
        background: var(--bg-white);
        border: 1px solid var(--border-color);
        color: var(--text-dark);
        border-radius: 10px;
        padding: 10px 16px;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: var(--bg-main);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .dropdown-menu {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        padding: 8px;
    }

    .dropdown-header {
        color: var(--text-dark);
        font-weight: 700;
        padding: 12px 16px;
        font-size: 14px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 10px 16px;
        transition: all 0.2s ease;
        color: var(--text-dark);
    }

    .dropdown-item:hover {
        background: var(--bg-main);
        color: var(--primary-color);
    }

    .dropdown-item i {
        width: 20px;
    }

    .badge {
        font-size: 10px;
        padding: 4px 6px;
    }
</style>