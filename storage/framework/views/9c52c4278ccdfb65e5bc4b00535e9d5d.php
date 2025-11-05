<?php $__env->startSection('title', 'Quản Lý Đánh Giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Quản Lý Đánh Giá</h1>
    </div>

    <!-- FLASH MESSAGE -->
    <?php if(session('success')): ?>
        <div class="alert alert-success d-flex align-items-center mb-3" style="background-color: #E6F7E9; border: 1px solid #69DB7C; color: #1E293B; border-radius: 8px; padding: 12px 16px;" role="alert">
            <i class="fas fa-check-circle me-2" style="color: #69DB7C;"></i>
            <strong><?php echo e(session('success')); ?></strong>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger d-flex align-items-center mb-3" style="background-color: #FFE8ED; border: 1px solid #FF6B81; color: #1E293B; border-radius: 8px; padding: 12px 16px;" role="alert">
            <i class="fas fa-exclamation-triangle me-2" style="color: #FF6B81;"></i>
            <strong><?php echo e(session('error')); ?></strong>
        </div>
    <?php endif; ?>

    <!-- Lọc trạng thái -->
    <div class="d-flex justify-content-end align-items-center mb-3">
        <form method="GET" class="d-flex gap-2">
            <select name="status" class="form-select" style="width: auto; border-color: #F0D9DE; font-size: 0.9rem;" onchange="this.form.submit()">
                <option value="">Tất cả</option>
                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ duyệt</option>
                <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Đã duyệt</option>
                <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Từ chối</option>
            </select>
        </form>
    </div>

    <!-- Bảng danh sách -->
    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Nội dung</th>
                            <th>Điểm</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #F0D9DE;">
                                <td style="color: #1E293B; font-weight: 500;">#<?php echo e($review->id); ?></td>

                                <!-- Người dùng: không bao giờ N/A -->
                                <td style="color: #1E293B;">
                                     <?php echo e($review->user->full_name ?? 'Khách vãng lai'); ?>

                                </td>

                                <td style="color: #1E293B;">
                                    <?php echo e($review->product->name ?? 'Sản phẩm đã xóa'); ?>

                                </td>

                                <td style="max-width: 220px; color: #1E293B; line-height: 1.5;">
                                    <?php echo e(Str::limit(strip_tags($review->comment), 60)); ?>

                                </td>

                                <td>
                                    <span style="color: #FF6B81; font-size: 1.1em;">
                                        <?php for($i = 0; $i < $review->rating; $i++): ?> ⭐ <?php endfor; ?>
                                    </span>
                                    <small class="text-muted">(<?php echo e($review->rating); ?>)</small>
                                </td>

                                <!-- Trạng thái -->
                                <td>
                                    <?php
                                        $statusConfig = [
                                            'pending'   => ['label' => 'Chờ duyệt', 'bg' => '#FFD43B', 'text' => '#1E293B'],
                                            'approved'  => ['label' => 'Đã duyệt',  'bg' => '#69DB7C', 'text' => 'white'],
                                            'rejected'  => ['label' => 'Từ chối',   'bg' => '#FF6B81', 'text' => 'white'],
                                        ];
                                        $cfg = $statusConfig[$review->status] ?? ['label' => 'Không xác định', 'bg' => '#F0D9DE', 'text' => '#1E293B'];
                                    ?>
                                    <span class="badge fw-medium px-2 py-1" style="background-color: <?php echo e($cfg['bg']); ?>; color: <?php echo e($cfg['text']); ?>; font-size: 0.8rem;">
                                        <?php echo e($cfg['label']); ?>

                                    </span>
                                </td>

                                <td style="color: #475569; font-size: 0.875rem;">
                                    <?php echo e($review->created_at->format('d/m H:i')); ?>

                                </td>

                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.reviews.edit', $review->id)); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.4rem 0.6rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Xóa vĩnh viễn đánh giá này?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm" style="background-color: #FF99AC; color: white; border: none; padding: 0.4rem 0.6rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5" style="color: #94A3B8;">
                                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                    <span>Không có đánh giá nào.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="px-4 py-3 bg-white border-top" style="border-color: #F0D9DE !important;">
                <?php echo e($reviews->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>