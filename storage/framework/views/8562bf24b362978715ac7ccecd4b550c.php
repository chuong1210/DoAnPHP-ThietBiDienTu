<?php $__env->startSection('title', 'Chi Tiết Sản Phẩm'); ?>
<?php $__env->startSection('page-title', 'Chi Tiết Sản Phẩm'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* === PAGE HEADER === */
        .page-header {
            background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .header-actions .btn {
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            backdrop-filter: blur(10px);
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .header-actions .btn:hover {
            background: white;
            color: #0066FF;
            border-color: white;
        }

        .breadcrumb {
            background: transparent;
            margin: 0.5rem 0 0 0;
            padding: 0;
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb-item.active {
            color: white;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.6);
        }

        /* === CARDS === */
        .card {
            border: 1px solid #CBD5E1;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(30, 41, 59, 0.04);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: #F8FAFC;
            border-bottom: 1px solid #CBD5E1;
            padding: 1.25rem 1.5rem;
        }

        .card-header h5 {
            margin: 0;
            color: #1E293B;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* === PRODUCT IMAGE === */
        .product-image-container {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }

        .product-image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .no-image {
            background: #F8FAFC;
            padding: 4rem 2rem;
            border-radius: 12px;
            text-align: center;
        }

        .no-image i {
            font-size: 4rem;
            color: #CBD5E1;
            margin-bottom: 1rem;
        }

        .no-image p {
            color: #94A3B8;
            margin: 0;
        }

        /* === PRODUCT INFO === */
        .product-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1E293B;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .product-badges {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .badge-featured {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-inactive {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* === INFO TABLE === */
        .info-table {
            width: 100%;
        }

        .info-table tr {
            border-bottom: 1px solid #F1F5F9;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table th {
            padding: 0.875rem 0;
            color: #64748B;
            font-weight: 600;
            font-size: 0.9375rem;
            width: 140px;
            text-align: left;
        }

        .info-table td {
            padding: 0.875rem 0;
            color: #1E293B;
            font-weight: 500;
        }

        .price-display {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .price-current {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0066FF;
        }

        .price-original {
            font-size: 1.125rem;
            color: #94A3B8;
            text-decoration: line-through;
        }

        .discount-badge {
            background: #DC2626;
            color: white;
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.8125rem;
            font-weight: 700;
        }

        .stock-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.9375rem;
            font-weight: 600;
        }

        .stock-available {
            background: #D1FAE5;
            color: #065F46;
        }

        .stock-low {
            background: #FEF3C7;
            color: #92400E;
        }

        .stock-out {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* === DESCRIPTION === */
        .product-description {
            color: #64748B;
            line-height: 1.7;
            font-size: 0.9375rem;
        }

        /* === STATS CARD === */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-item {
            background: #F8FAFC;
            padding: 1.25rem;
            border-radius: 12px;
            text-align: center;
        }

        .stat-label {
            color: #64748B;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            color: #0066FF;
            font-size: 1.875rem;
            font-weight: 700;
        }

        /* === META INFO === */
        .meta-info {
            background: #F8FAFC;
            padding: 1.25rem;
            border-radius: 12px;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            padding: 0.625rem 0;
            border-bottom: 1px solid #E2E8F0;
        }

        .meta-item:last-child {
            border-bottom: none;
        }

        .meta-label {
            color: #64748B;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .meta-value {
            color: #1E293B;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* === REVIEW STATS === */
        .review-stats {
            text-align: center;
            padding: 1.5rem;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: 700;
            color: #0066FF;
            line-height: 1;
        }

        .rating-stars {
            color: #FBBF24;
            font-size: 1.25rem;
            margin: 0.5rem 0;
        }

        .rating-count {
            color: #64748B;
            font-size: 0.875rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1><i class="fas fa-cube me-2"></i>Chi Tiết Sản Phẩm</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.products.index')); ?>" style="color: rgba(255,255,255,0.8);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Chi tiết #<?php echo e($product->id); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn">
                    <i class="fas fa-edit me-2"></i>Chỉnh sửa
                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Product Overview -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-image-container">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>">
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                        <p>Không có hình ảnh</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="product-title"><?php echo e($product->name); ?></h2>

                            <div class="product-badges">
                                <?php if($product->is_featured): ?>
                                    <span class="badge badge-featured">
                                        <i class="fas fa-star me-1"></i>Nổi bật
                                    </span>
                                <?php endif; ?>
                                <?php if($product->status === 'active'): ?>
                                    <span class="badge badge-active">Đang hoạt động</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Không hoạt động</span>
                                <?php endif; ?>
                            </div>

                            <table class="info-table">
                                <tr>
                                    <th>Danh mục:</th>
                                    <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <th>Thương hiệu:</th>
                                    <td><?php echo e($product->brand->name ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <th>Giá:</th>
                                    <td>
                                        <div class="price-display">
                                            <span class="price-current"><?php echo e(number_format($product->price)); ?>đ</span>
                                            <?php if($product->sale_price): ?>
                                                <span class="price-original"><?php echo e(number_format($product->sale_price)); ?>đ</span>
                                                <span class="discount-badge">
                                                    -<?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tồn kho:</th>
                                    <td>
                                        <?php if($product->quantity > 10): ?>
                                            <span class="stock-badge stock-available">
                                                <i class="fas fa-check-circle me-1"></i><?php echo e($product->quantity); ?> sản phẩm
                                            </span>
                                        <?php elseif($product->quantity > 0): ?>
                                            <span class="stock-badge stock-low">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Còn <?php echo e($product->quantity); ?> sản phẩm
                                            </span>
                                        <?php else: ?>
                                            <span class="stock-badge stock-out">
                                                <i class="fas fa-times-circle me-1"></i>Hết hàng
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lượt xem:</th>
                                    <td><i class="fas fa-eye me-2" style="color: #00B4D8;"></i><?php echo e(number_format($product->view_count)); ?></td>
                                </tr>
                                <tr>
                                    <th>Đã bán:</th>
                                    <td><i class="fas fa-shopping-cart me-2" style="color: #0066FF;"></i><?php echo e(number_format($product->sold_count)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-align-left me-2"></i>Mô Tả Chi Tiết</h5>
                </div>
                <div class="card-body">
                    <?php if($product->description): ?>
                        <p class="product-description"><?php echo e($product->description); ?></p>
                    <?php else: ?>
                        <p class="text-muted" style="text-align: center; padding: 2rem;">
                            <i class="fas fa-info-circle me-2"></i>Chưa có mô tả chi tiết
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i>Thống Kê</h5>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-label">Lượt Xem</div>
                            <div class="stat-value"><?php echo e(number_format($product->view_count)); ?></div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Đã Bán</div>
                            <div class="stat-value"><?php echo e(number_format($product->sold_count)); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Thông Tin Khác</h5>
                </div>
                <div class="card-body">
                    <div class="meta-info">
                        <div class="meta-item">
                            <span class="meta-label">ID Sản Phẩm:</span>
                            <span class="meta-value">#<?php echo e($product->id); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">SKU:</span>
                            <span class="meta-value">PRO-<?php echo e($product->id); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Slug:</span>
                            <span class="meta-value"><?php echo e($product->slug); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Ngày tạo:</span>
                            <span class="meta-value"><?php echo e(optional($product->created_at)->format('d/m/Y H:i') ?? 'N/A'); ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Cập nhật:</span>
                            <span class="meta-value"><?php echo e(optional($product->updated_at)->format('d/m/Y H:i') ?? 'N/A'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-star me-2"></i>Đánh Giá</h5>
                </div>
                <div class="card-body">
                    <?php
                        $averageRating = $product->reviews->avg('rating');
                        $reviewCount = $product->reviews->count();
                    ?>

                    <div class="review-stats">
                        <?php if($averageRating > 0): ?>
                            <div class="rating-number"><?php echo e(number_format($averageRating, 1)); ?></div>
                            <div class="rating-stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= floor($averageRating)): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif($i - $averageRating < 1): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="rating-count"><?php echo e($reviewCount); ?> đánh giá</div>
                        <?php else: ?>
                            <div style="padding: 2rem; color: #94A3B8;">
                                <i class="far fa-star" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <p style="margin: 0;">Chưa có đánh giá nào</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/products/show.blade.php ENDPATH**/ ?>