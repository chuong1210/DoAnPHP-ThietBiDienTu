

<header class="top-bar">
    <div class="d-flex align-items-center">
        <button class="btn-toggle-sidebar me-3 d-lg-none">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
    </div>

    <div class="topbar-actions">
        <!-- Notifications -->
        <div class="dropdown">
            <button class="btn btn-light position-relative p-2" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fas fa-bell fs-5"></i>
                <?php
                    $totalNotifications = \App\Models\ChatMessage::whereHas('room', function ($q) {
                        $q->where('status', 'open');
                    })
                        ->where('is_admin', false)
                        ->where('is_read', false)
                        ->count();
                ?>
                <?php if($totalNotifications > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 10px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        <?php echo e($totalNotifications > 99 ? '99+' : $totalNotifications); ?>

                    </span>
                <?php endif; ?>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                style="min-width: 320px; border-radius: 16px; border: none;">
                <li class="dropdown-header px-4 py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="fs-6">Thông Báo</strong>
                        <?php if($totalNotifications > 0): ?>
                            <a href="<?php echo e(route('admin.chat.index')); ?>" class="small text-primary fw-medium">Xem tất cả</a>
                        <?php endif; ?>
                    </div>
                </li>

                <?php if($totalNotifications > 0): ?>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-3 px-4 py-3"
                            href="<?php echo e(route('admin.chat.index')); ?>">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold"><?php echo e($totalNotifications); ?> tin nhắn mới</div>
                                <small class="text-muted">Khách hàng đang chờ phản hồi</small>
                            </div>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="px-4 py-5 text-center">
                        <i class="fas fa-bell-slash text-muted opacity-50 mb-3" style="font-size: 36px;"></i>
                        <p class="text-muted mb-0 small">Không có thông báo mới</p>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="dropdown">
            <button class="btn btn-light d-flex align-items-center gap-2 p-2 rounded-pill" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://cdn-icons-png.flaticon.com/512/8188/8188362.png" alt="Admin" class="user-avatar">
                <span class="d-none d-md-inline fw-medium"><?php echo e(Auth::user()->full_name); ?></span>
                <i class="fas fa-chevron-down text-muted" style="font-size: 11px;"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                style="border-radius: 16px; border: none; min-width: 220px;">
                <li class="dropdown-header px-4 py-3 text-center border-bottom">
                    <img src="https://cdn-icons-png.flaticon.com/512/8188/8188362.png" alt="Admin"
                        class="user-avatar mb-2">
                    <div class="fw-bold"><?php echo e(Auth::user()->full_name); ?></div>
                    <small class="text-muted"><?php echo e(Auth::user()->email); ?></small>
                </li>
                <li><a class="dropdown-item px-4 py-2" href="#"><i class="fas fa-user me-3 text-primary"></i> Hồ Sơ</a>
                </li>
                <li><a class="dropdown-item px-4 py-2" href="#"><i class="fas fa-cog me-3 text-secondary"></i> Cài
                        Đặt</a></li>
                <li>
                    <hr class="dropdown-divider mx-3">
                </li>
                <li>
                    <a class="dropdown-item px-4 py-2 text-danger fw-medium" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-3"></i> Đăng Xuất
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
                </li>
            </ul>
        </div>
    </div>
</header>

<style>
    :root {
        --primary: #0066FF;
        --secondary: #00B4D8;
        --bg-card: #FFFFFF;
        --text-dark: #1E293B;
        --text-muted: #64748B;
        --border: #CBD5E1;
        --shadow-lg: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .top-bar {
        height: 70px;
        background: var(--bg-card);
        padding: 0 30px;
        border-bottom: 1px solid var(--border);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
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
        background: linear-gradient(135deg, var(--primary), #3388FF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .topbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-toggle-sidebar {
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

    .btn-light {
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--text-dark);
        border-radius: 12px;
        padding: 8px;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-light:hover {
        border-color: var(--primary);
        background: rgba(0, 102, 255, 0.05);
        color: var(--primary);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid var(--primary);
        box-shadow: 0 2px 8px rgba(0, 102, 255, 0.2);
    }

    /* Dropdown Menu */
    .dropdown-menu {
        padding: 0;
        overflow: hidden;
        animation: dropdownSlide 0.25s ease-out;
    }

    @keyframes dropdownSlide {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-header {
        background: linear-gradient(135deg, var(--primary), #3388FF);
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .dropdown-header .text-primary {
        color: #CCE5FF !important;
    }

    .dropdown-item {
        border-radius: 10px;
        margin: 4px 8px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: rgba(0, 102, 255, 0.08);
        color: var(--primary);
        transform: translateX(4px);
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    .badge {
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .top-bar {
            padding: 0 15px;
        }

        .page-title {
            font-size: 18px;
        }

        .topbar-actions .btn-light span {
            display: none;
        }
    }
</style><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/partials/header.blade.php ENDPATH**/ ?>