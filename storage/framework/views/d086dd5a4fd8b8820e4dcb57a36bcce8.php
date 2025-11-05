

<div class="sidebar">
    <!-- Brand -->
    <div class="brand">
        <h4>
            <i class="fas fa-gem"></i>
            Admin Panel
        </h4>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
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
$unreadCount = \App\Models\ChatMessage::whereHas('room', function ($q) {
    $q->where('status', 'open');
})
    ->where('is_admin', false)
    ->where('is_read', false)
    ->count();
            ?>
            <?php if($unreadCount > 0): ?>
                <span class="nav-badge"><?php echo e($unreadCount); ?></span>
            <?php endif; ?>
        </a>

                <!-- User Management Section -->
                <div class="nav-section-title">
                    <i class="fas fa-user-cog me-1"></i> User
                </div>

                <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
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
            <i class="fas fa-image"></i> Quản Lý Banner
        </a>
        <a href="<?php echo e(route('admin.reviews.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
            <i class="fas fa-image"></i> Quản Lý Reviews
        </a>

        <a href="<?php echo e(route('admin.contact.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.contact.*') ? 'active' : ''); ?>">
            <i class="fas fa-headset"></i> Quản Lý Liên Hệ
        </a>
        <a href="<?php echo e(route('admin.faqs.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.faqs.*') ? 'active' : ''); ?>">
            <i class="fas fa-question-circle"></i> Quản Lý Câu Hỏi Thường Gặp
        </a>
        <hr class="bg-secondary">

        <a href="<?php echo e(route('client.home.index')); ?>" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i>
            <span>Xem Trang Client</span>
            <i class="fas fa-external-link-alt ms-auto" style="font-size: 12px; opacity: 0.6;"></i>
        </a>

        <a href="<?php echo e(route('logout')); ?>" class="nav-link" onclick="return confirm('Bạn có chắc muốn đăng xuất?')">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng Xuất</span>
        </a>
    </nav>
</div>



<?php /**PATH D:\Nam4\PHP\DoAnPHP-ThietBiDienTu\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>