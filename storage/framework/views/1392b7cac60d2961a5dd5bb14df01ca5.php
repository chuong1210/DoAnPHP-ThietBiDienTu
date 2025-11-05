<?php $__env->startSection('title', 'Quản Lý Sản Phẩm'); ?>
<?php $__env->startSection('page-title', 'Quản Lý Sản Phẩm'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* === HEADER & ACTIONS === */
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

        .btn-add-product {
            background: white;
            color: #0066FF;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-product:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 255, 255, 0.4);
            color: #0066FF;
        }

        /* === FILTER CARD === */
        .filter-card {
            background: #F8FAFC;
            border: 1px solid #CBD5E1;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            background: white;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            padding: 0.625rem 1rem;
            font-size: 0.9375rem;
            color: #1E293B;
            transition: all 0.2s ease;
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: #0066FF;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
            background: white;
        }

        .filter-card .btn-primary {
            background: #0066FF;
            border: none;
            border-radius: 10px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .filter-card .btn-primary:hover {
            background: #0052CC;
            transform: translateY(-1px);
        }

        .filter-card .btn-secondary {
            background: white;
            border: 1px solid #CBD5E1;
            color: #64748B;
            border-radius: 10px;
            padding: 0.625rem 1rem;
            transition: all 0.2s ease;
        }

        .filter-card .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #0066FF;
            color: #0066FF;
        }

        /* === PRODUCT TABLE === */
        .product-table-card {
            background: white;
            border: 1px solid #CBD5E1;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(30, 41, 59, 0.04);
        }

        .product-table-card .table {
            margin: 0;
        }

        .product-table-card thead th {
            background: #F8FAFC;
            color: #1E293B;
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #CBD5E1;
            padding: 1rem;
            white-space: nowrap;
        }

        .product-table-card tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #1E293B;
            border-bottom: 1px solid #F1F5F9;
        }

        .product-table-card tbody tr {
            transition: all 0.2s ease;
        }

        .product-table-card tbody tr:hover {
            background: #F8FAFC;
        }

        /* === PRODUCT IMAGE === */
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            background: #F8FAFC;
            padding: 4px;
            border: 1px solid #CBD5E1;
        }

        /* === BADGES === */
        .badge-status {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-status.active {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-status.inactive {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-quantity {
            background: #E0E7FF;
            color: #3730A3;
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .badge-featured {
            background: #FEF3C7;
            color: #92400E;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.6875rem;
            font-weight: 600;
        }

        /* === ACTION BUTTONS === */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .action-buttons .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
        }

        .action-buttons .btn-info {
            background: #DBEAFE;
            color: #0066FF;
        }

        .action-buttons .btn-info:hover {
            background: #0066FF;
            color: white;
            transform: translateY(-2px);
        }

        .action-buttons .btn-warning {
            background: #FFEDD5;
            color: #EA580C;
        }

        .action-buttons .btn-warning:hover {
            background: #EA580C;
            color: white;
            transform: translateY(-2px);
        }

        .action-buttons .btn-danger {
            background: #FEE2E2;
            color: #DC2626;
        }

        .action-buttons .btn-danger:hover {
            background: #DC2626;
            color: white;
            transform: translateY(-2px);
        }

        /* === PRODUCT NAME LINK === */
        .product-name-link {
            color: #1E293B;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .product-name-link:hover {
            color: #0066FF;
        }

        /* === PRICE DISPLAY === */
        .price-current {
            color: #0066FF;
            font-weight: 700;
            font-size: 1rem;
        }

        .price-original {
            color: #94A3B8;
            text-decoration: line-through;
            font-size: 0.875rem;
        }

        /* === EMPTY STATE === */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            font-size: 4rem;
            color: #CBD5E1;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #64748B;
            font-size: 1.125rem;
            margin: 0;
        }

        /* === PAGINATION === */
        .pagination {
            margin-top: 1.5rem;
        }

        .pagination .page-link {
            color: #0066FF;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            margin: 0 0.25rem;
            padding: 0.5rem 0.75rem;
        }

        .pagination .page-link:hover {
            background: #F8FAFC;
            border-color: #0066FF;
        }

        .pagination .page-item.active .page-link {
            background: #0066FF;
            border-color: #0066FF;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1><i class="fas fa-box-open me-2"></i>Danh Sách Sản Phẩm</h1>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-add-product">
                <i class="fas fa-plus me-2"></i>Thêm Sản Phẩm Mới
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên sản phẩm..."
                        value="<?php echo e(request('keyword')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="brand_id" class="form-select">
                        <option value="">Tất cả thương hiệu</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>
                            Đang bán
                        </option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>
                            Ngừng bán
                        </option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary grow">
                        <i class="fas fa-search me-1"></i> Tìm kiếm
                    </button>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="product-table-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px;">ID</th>
                        <th style="width: 80px;">Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th style="width: 140px;">Danh Mục</th>
                        <th style="width: 140px;">Thương Hiệu</th>
                        <th style="width: 150px;">Giá</th>
                        <th style="width: 80px;" class="text-center">Kho</th>
                        <th style="width: 120px;" class="text-center">Trạng Thái</th>
                        <th style="width: 140px;" class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong>#<?php echo e($product->id); ?></strong></td>
                            <td>
                                <img src="<?php echo e(asset($product->image ?? 'https://placehold.co/60x60/F8FAFC/CBD5E1?text=No+Image')); ?>"
                                    alt="<?php echo e($product->name); ?>" class="product-image">
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                    class="product-name-link d-block mb-1">
                                    <?php echo e(Str::limit($product->name, 45)); ?>

                                </a>
                                <?php if($product->is_featured): ?>
                                    <span class="badge-featured">
                                        <i class="fas fa-star me-1"></i>Nổi bật
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="color: #64748B;"><?php echo e($product->category->name ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <span style="color: #64748B;"><?php echo e($product->brand->name ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <?php if($product->sale_price): ?>
                                    <div class="price-current"><?php echo e(number_format($product->sale_price)); ?>đ</div>
                                    <div class="price-original"><?php echo e(number_format($product->price)); ?>đ</div>
                                <?php else: ?>
                                    <div class="price-current"><?php echo e(number_format($product->price)); ?>đ</div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge-quantity"><?php echo e($product->quantity); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($product->status == 'active'): ?>
                                    <span class="badge-status active">Đang bán</span>
                                <?php else: ?>
                                    <span class="badge-status inactive">Ngừng bán</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" class="btn btn-info"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fas fa-box-open"></i>
                                    <p>Không tìm thấy sản phẩm nào</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($products->hasPages()): ?>
            <div class="px-4 pb-4">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/products/index.blade.php ENDPATH**/ ?>