<?php $__env->startSection('title', 'Quản Lý Danh Mục'); ?>
<?php $__env->startSection('page-title', 'Quản Lý Danh Mục'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Nút Thêm Mới */
        .btn-add-category {
            background: var(--primary-gradient);
            color: rgb(4, 146, 233);

            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 59, 63, 0.3);
            transition: all 0.3s ease;
        }

        .btn-add-category:hover {
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
            vertical-align: middle;
            /* Căn giữa chiều dọc cho header */
        }

        .table tbody tr:hover {
            background-color: var(--bg-main);
        }

        /* Thêm style cho ảnh danh mục */
        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            /* Dùng 'cover' để ảnh lấp đầy khung */
            border-radius: 12px;
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

        /* Nút Hành Động trong bảng */
        .action-buttons .btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s ease;
            border: none;
        }

        .action-buttons .btn-edit {
            background-color: #ffedd5;
            color: #9a3412;
        }

        .action-buttons .btn-edit:hover {
            background-color: #fed7aa;
            transform: scale(1.1);
        }

        .action-buttons .btn-delete {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-buttons .btn-delete:hover {
            background-color: #fecaca;
            transform: scale(1.1);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh Sách Danh Mục</h5>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-add-category">
                <i class="fas fa-plus me-2"></i> Thêm Mới
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th> 
                            <th>Tên Danh Mục</th>
                            <th>Slug</th>
                            <th>Trạng Thái</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($category->id); ?></strong></td>
                                <td>
                                    
                                    <img src="<?php echo e(asset($category->image ?? 'https://static.vecteezy.com/system/resources/previews/016/916/479/original/placeholder-icon-design-free-vector.jpg')); ?>"
                                        alt="<?php echo e($category->name); ?>" class="category-image">
                                </td>
                                <td>
                                    <span class="fw-bold"><?php echo e($category->name); ?></span>
                                </td>
                                <td><code class="text-muted"><?php echo e($category->slug); ?></code></td>
                                <td>
                                    <?php if($category->is_active): ?>
                                        <span class="badge badge-status active">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge badge-status inactive">Tạm ẩn</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-edit"
                                        title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Tất cả sản phẩm thuộc danh mục này cũng có thể bị ảnh hưởng.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-delete" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5"> 
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <p class="mb-0">Chưa có danh mục nào.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($categories->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($categories->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>