<?php $__env->startSection('title', 'Chi Tiết Sản Phẩm'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Chi Tiết Sản Phẩm</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Hình ảnh và thông tin cơ bản -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset('' . $product->image)); ?>" alt="<?php echo e($product->name); ?>"
                                        class="img-fluid rounded">
                                <?php else: ?>
                                    <div class="bg-light text-center py-5 rounded">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2">Không có hình ảnh</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7">
                                <h2 class="mb-3"><?php echo e($product->name); ?></h2>

                                <div class="mb-3">
                                    <?php if($product->is_featured): ?>
                                        <span class="badge bg-warning text-dark">Nổi bật</span>
                                    <?php endif; ?>
                                    <?php if($product->status === 'active'): ?>
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    <?php endif; ?>
                                </div>

                                <table class="table">
                                    <tr>
                                        <th width="150">Danh mục:</th>
                                        <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Thương hiệu:</th>
                                        <td><?php echo e($product->brand->name ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Giá gốc:</th>
                                        <td>
                                            <strong class="text-primary"><?php echo e(number_format($product->price)); ?>đ</strong>
                                        </td>
                                    </tr>
                                    <?php if($product->sale_price): ?>
                                        <tr>
                                            <th>Giá khuyến mãi:</th>
                                            <td>
                                                <strong class="text-danger"><?php echo e(number_format($product->sale_price)); ?>đ</strong>
                                                <span class="badge bg-danger">
                                                    -<?php echo e($product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0); ?>%
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th>Số lượng:</th>
                                        <td>
                                            <?php if($product->quantity > 0): ?>
                                                <span class="badge bg-success"><?php echo e($product->quantity); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Hết hàng</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lượt xem:</th>
                                        <td><?php echo e(number_format($product->view_count)); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Đã bán:</th>
                                        <td><?php echo e(number_format($product->sold_count)); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mô tả -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mô Tả Chi Tiết</h5>
                    </div>
                    <div class="card-body">
                        <?php if($product->description): ?>
                            <p><?php echo e($product->description); ?></p>
                        <?php else: ?>
                            <p class="text-muted">Chưa có mô tả</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông Tin Khác</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>SKU:</strong> PRO-<?php echo e($product->id); ?></p>
                        <p><strong>Slug:</strong> <?php echo e($product->slug); ?></p>
                        <p><strong>Ngày tạo:</strong> <?php echo e(optional($product->created_at)->format('d/m/Y H:i') ?? 'Chưa có'); ?>

                        </p>
                        <p><strong>Cập nhật:</strong> <?php echo e(optional($product->updated_at)->format('d/m/Y H:i') ?? 'Chưa có'); ?>

                        </p>
                    </div>
                </div>

                <!-- Đánh giá -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Đánh Giá</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>Điểm trung bình:</strong>
                            <?php
                                $averageRating = $product->reviews->avg('rating');
                            ?>
                            <?php if($averageRating > 0): ?>
                                <span class="text-warning">
                                    <?php echo e(number_format($averageRating, 1)); ?>/5
                                    <i class="fas fa-star"></i>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Chưa có đánh giá</span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Số đánh giá:</strong> <?php echo e($product->reviews->count()); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/products/show.blade.php ENDPATH**/ ?>