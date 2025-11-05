<div class="sidebar">
    <div class="brand">
        <i class="fas fa-store"></i> Admin Panel
    </div>

    <nav class="nav flex-column mt-3">
        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="<?php echo e(route('admin.products.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
            <i class="fas fa-box"></i> Quản Lý Sản Phẩm
        </a>

        <a href="<?php echo e(route('admin.categories.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="fas fa-list"></i> Quản Lý Danh Mục
        </a>

        <a href="<?php echo e(route('admin.brands.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
            <i class="fas fa-tag"></i> Quản Lý Thương Hiệu
        </a>

        <a href="<?php echo e(route('admin.orders.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
            <i class="fas fa-shopping-cart"></i> Quản Lý Đơn Hàng
        </a>

        <a href="<?php echo e(route('admin.banners.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.banners.*') ? 'active' : ''); ?>">
            <i class="fas fa-image"></i> Quản Lý Banners
        </a>

        <a href="<?php echo e(route('admin.reviews.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
            <i class="fas fa-comments"></i> Quản Lý Reviews
        </a>

        <a href="<?php echo e(route('admin.contact.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.contact.*') ? 'active' : ''); ?>">
            <i class="fas fa-headset"></i> Quản Lý Contacts
        </a>

        <a href="<?php echo e(route('admin.faqs.index')); ?>"
            class="nav-link <?php echo e(request()->routeIs('admin.faqs.*') ? 'active' : ''); ?>">
            <i class="fas fa-question-circle"></i> Quản Lý FAQS
        </a>

        <hr class="bg-secondary">

        <a href="<?php echo e(route('client.home.index')); ?>" class="nav-link" target="_blank">
            <i class="fas fa-globe"></i> Xem Trang Client
        </a>
    </nav>
</div>
<?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>