<?php $__env->startSection('title', 'Quản Lý Sản Phẩm'); ?>
<?php $__env->startSection('page-title', 'Quản Lý Sản Phẩm'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Nút Thêm Mới */
        .btn-add-product {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 59, 63, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-product:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 59, 63, 0.4);
        }

        /* Bảng Dữ Liệu */
        .table thead th {
            background-color: var(--bg-main);
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: var(--bg-main);
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid var(--border-color);
        }

        .badge-status {
            font-size: 0.8rem;
            padding: 0.4em 0.8em;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-status.active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-status.inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-quantity {
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .badge-featured {
            background-color: #fef3c7;
            color: #92400e;
        }

        /* Nút Hành Động trong bảng */
        .action-buttons .btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
        }

        .action-buttons .btn-info {
            background-color: #cffafe;
            color: #0e7490;
        }

        .action-buttons .btn-info:hover {
            background-color: #a5f3fc;
        }

        .action-buttons .btn-warning {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .action-buttons .btn-warning:hover {
            background-color: #fed7aa;
        }

        .action-buttons .btn-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons .btn-danger:hover {
            background-color: #fecaca;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Danh Sách Sản Phẩm</h1>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-add-product">
            <i class="fas fa-plus me-2"></i> Thêm Sản Phẩm Mới
        </a>
    </div>

    <!-- Bộ lọc và tìm kiếm -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.products.index')); ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên..."
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
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Đang bán</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Ngừng bán
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Lọc</button>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary w-100"><i
                                class="fas fa-sync-alt"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width: 80px;">Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Thương Hiệu</th>
                            <th>Giá</th>
                            <th>Kho</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($product->id); ?></strong></td>
                                <td>
                                    <img src="<?php echo e(asset($product->image ?? 'https://media.geeksforgeeks.org/wp-content/uploads/20230802153215/Error-404-768.png')); ?>"
                                        alt="<?php echo e($product->name); ?>" class="product-image">
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                        class="fw-bold text-dark text-decoration-none">
                                        <?php echo e(Str::limit($product->name, 45)); ?>

                                    </a>
                                    <?php if($product->is_featured): ?>
                                        <span class="badge badge-featured ms-1" title="Sản phẩm nổi bật">Nổi bật</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                <td><?php echo e($product->brand->name ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($product->sale_price): ?>
                                        <span class="text-danger fw-bold"><?php echo e(number_format($product->sale_price)); ?>đ</span>
                                        <br>
                                        <small
                                            class="text-decoration-line-through text-muted"><?php echo e(number_format($product->price)); ?>đ</small>
                                    <?php else: ?>
                                        <span class="fw-bold"><?php echo e(number_format($product->price)); ?>đ</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-quantity"><?php echo e($product->quantity); ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if($product->status == 'active'): ?>
                                        <span class="badge badge-status active">Đang bán</span>
                                    <?php else: ?>
                                        <span class="badge badge-status inactive">Ngừng bán</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons btn-group">
                                        <a href="<?php echo e(route('admin.products.show', $product->id)); ?>" class="btn btn-info"
                                            title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning"
                                            title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Mọi dữ liệu liên quan cũng sẽ bị ảnh hưởng.')">
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
                                <td colspan="9" class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Không có sản phẩm nào.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($products->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Nam4\PHP\DoAnPHP-ThietBiDienTu\resources\views/admin/products/index.blade.php ENDPATH**/ ?>