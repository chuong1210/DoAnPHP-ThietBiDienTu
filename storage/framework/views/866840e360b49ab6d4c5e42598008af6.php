

<div class="sidebar">
    <!-- Brand with Logo -->
    <div class="brand">
        <div class="d-flex align-items-center justify-content-center">
            <img src="https://cdn-icons-png.flaticon.com/512/2304/2304226.png" alt="Logo" class="brand-logo me-2">
            <h4 class="mb-0 fw-bold">Admin Panel</h4>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav mt-3">
        <!-- Main Section -->
        <div class="nav-section-title">
            <i class="fas fa-chart-line me-1"></i> Tổng Quan
        </div>

        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <!-- Products Section -->
        <div class="nav-section-title">
            <i class="fas fa-shopping-bag me-1"></i> Sản Phẩm
        </div>

        <a href="<?php echo e(route('admin.products.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
            <i class="fas fa-box"></i>
            <span>Quản Lý Sản Phẩm</span>
        </a>

        <a href="<?php echo e(route('admin.categories.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-list"></i>
            <span>Danh Mục</span>
        </a>

        <a href="<?php echo e(route('admin.brands.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
            <i class="fas fa-tag"></i>
            <span>Thương Hiệu</span>
        </a>

        <!-- Orders Section -->
        <div class="nav-section-title">
            <i class="fas fa-receipt me-1"></i> Đơn Hàng
        </div>

        <a href="<?php echo e(route('admin.orders.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Quản Lý Đơn Hàng</span>
            <?php if(isset($pendingOrdersCount) && $pendingOrdersCount > 0): ?>
                <span class="nav-badge"><?php echo e($pendingOrdersCount); ?></span>
            <?php endif; ?>
        </a>

        <!-- Communication Section -->
        <div class="nav-section-title">
            <i class="fas fa-users me-1"></i> Khách Hàng
        </div>

        <a href="<?php echo e(route('admin.chat.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.chat.*') ? 'active' : ''); ?>">
            <i class="fas fa-comments"></i>
            <span>Chat Hỗ Trợ</span>
            <?php
                $unreadCount = \App\Models\ChatMessage::whereHas('room', fn($q) => $q->where('status', 'open'))
                    ->where('is_admin', false)->where('is_read', false)->count();
            ?>
            <?php if($unreadCount > 0): ?>
                <span class="nav-badge"><?php echo e($unreadCount); ?></span>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('admin.users.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="fas fa-user-friends"></i>
            <span>Quản Lý User</span>
        </a>

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Settings Section -->
        <div class="nav-section-title">
            <i class="fas fa-cog me-1"></i> Hệ Thống
        </div>

        <a href="<?php echo e(route('admin.banners.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>">
            <i class="fas fa-image"></i>
            <span>Quản Lý Banners</span>
        </a>

        <a href="<?php echo e(route('admin.reviews.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
            <i class="fas fa-star"></i>
            <span>Quản Lý Reviews</span>
        </a>

        <a href="<?php echo e(route('admin.contact.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.contact.*') ? 'active' : ''); ?>">
            <i class="fas fa-headset"></i>
            <span>Quản Lý Liên Hệ</span>
        </a>

        <a href="<?php echo e(route('admin.faqs.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.faqs.*') ? 'active' : ''); ?>">
            <i class="fas fa-question-circle"></i>
            <span>FAQ</span>
        </a>

        <hr class="bg-secondary opacity-10 mx-3">

        <a href="<?php echo e(route('client.home.index')); ?>" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i>
            <span>Xem Trang Client</span>
            <i class="fas fa-external-link-alt ms-auto" style="font-size: 11px; opacity: 0.6;"></i>
        </a>

        <a href="<?php echo e(route('logout')); ?>" class="nav-link text-danger"
            onclick="event.preventDefault(); if(confirm('Bạn có chắc muốn đăng xuất?')) document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng Xuất</span>
        </a>
        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
            <?php echo csrf_field(); ?>
        </form>
    </nav>
</div><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>