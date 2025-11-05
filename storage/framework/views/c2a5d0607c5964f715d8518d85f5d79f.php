<?php $__env->startSection('title', 'Quản Lý Banner'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
        <!-- Updated header styling with red gradient and pink background -->
        <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
            <h1 class="h3 mb-0">📋 Quản Lý Banner</h1>
        </div>

        <!-- Search Form -->
        <div class="card mb-4" style="border: 1px solid #F0D9DE; border-radius: 8px;">
            <div class="card-body" style="background-color: white;">
                <form method="GET" action="<?php echo e(route('admin.banners.index')); ?>" class="mb-0">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm banner..." value="<?php echo e(request('keyword')); ?>" style="border-color: #F0D9DE;">
                        <!-- Red gradient button for search -->
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Button -->
        <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-lg mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
            <i class="fas fa-plus"></i> Thêm Banner
        </a>

        <!-- Banner Table -->
        <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="border-color: #F0D9DE;">
                        <thead style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white;">
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Liên kết</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr style="border-bottom: 1px solid #F0D9DE;">
                                    <td style="color: #1E293B;"><?php echo e($banner->id); ?></td>
                                    <td style="color: #1E293B; font-weight: 500;"><?php echo e($banner->title); ?></td>
                                    <td>
                                        <?php if($banner->image && file_exists(public_path('images/' . $banner->image))): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo e($banner->id); ?>">
                                                <img src="<?php echo e(asset('images/' . $banner->image)); ?>" alt="<?php echo e($banner->title); ?>" style="max-width: 100px; border-radius: 4px;">
                                            </a>
                                            <!-- Modal with updated styling -->
                                            <div class="modal fade" id="imageModal<?php echo e($banner->id); ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo e($banner->id); ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="border: 1px solid #F0D9DE; border-radius: 8px;">
                                                        <div class="modal-header" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                                                            <h5 class="modal-title" id="imageModalLabel<?php echo e($banner->id); ?>"><?php echo e($banner->title); ?></h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center" style="background-color: #FFF5F7;">
                                                            <img src="<?php echo e(asset('images/' . $banner->image)); ?>" alt="<?php echo e($banner->title); ?>" style="max-width: 100%; height: auto; border-radius: 4px;">
                                                        </div>
                                                        <div class="modal-footer" style="background-color: white; border-top: 1px solid #F0D9DE;">
                                                            <button type="button" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none;" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span style="color: #FF3B3F;">Ảnh không tồn tại</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color: #1E293B;">
                                        <?php if($banner->link): ?>
                                            <a href="<?php echo e($banner->link); ?>" target="_blank" style="color: #FF3B3F; text-decoration: none;"><?php echo e(\Illuminate\Support\Str::limit($banner->link, 30)); ?></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td style="color: #1E293B;"><?php echo e($banner->sort_order); ?></td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo e($banner->is_active ? '#FF99AC' : '#F0D9DE'); ?>; color: #1E293B;">
                                            <?php echo e($banner->is_active ? 'Hiển thị' : 'Ẩn'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; text-decoration: none;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.banners.destroy', $banner->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm" style="background-color: #FF99AC; color: white; border: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center" style="color: #1E293B; padding: 20px;">Không có banner nào.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div style="padding: 15px; border-top: 1px solid #F0D9DE;">
                    <?php echo e($banners->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>