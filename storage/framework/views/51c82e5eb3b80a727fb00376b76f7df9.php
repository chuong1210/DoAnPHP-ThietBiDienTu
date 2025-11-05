<?php $__env->startSection('title', 'Duyệt Đánh Giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Duyệt Đánh Giá #<?php echo e($review->id); ?></h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 650px; margin: 0 auto;">
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.reviews.update', $review->id)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <!-- Thông tin chỉ xem -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Người dùng</label>
                        <p class="fw-500" style="color: #1E293B;"><?php echo e($review->user->name ?? $review->user_name); ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Sản phẩm</label>
                        <p class="fw-500" style="color: #1E293B;"><?php echo e($review->product->name ?? 'N/A'); ?></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small">Nội dung</label>
                        <p class="border rounded p-3 bg-light" style="color: #1E293B; line-height: 1.6;">
                            <?php echo nl2br(e($review->comment)); ?>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Điểm</label>
                        <p class="fw-500" style="color: #1E293B;">
                            <?php for($i = 0; $i < $review->rating; $i++): ?> ⭐ <?php endfor; ?>
                            (<?php echo e($review->rating); ?> sao)
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Thời gian</label>
                        <p class="fw-500" style="color: #475569;"><?php echo e($review->created_at->format('d/m/Y H:i')); ?></p>
                    </div>
                </div>

                <hr style="border-color: #F0D9DE;">

                <!-- Chỉnh sửa trạng thái -->
                <div class="mb-4">
                    <label class="form-label fw-500" style="color: #1E293B;">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-color: #F0D9DE;" required>
                        <option value="pending" <?php echo e(old('status', $review->status) == 'pending' ? 'selected' : ''); ?>>Chờ duyệt</option>
                        <option value="approved" <?php echo e(old('status', $review->status) == 'approved' ? 'selected' : ''); ?>>Đã duyệt</option>
                        <option value="rejected" <?php echo e(old('status', $review->status) == 'rejected' ? 'selected' : ''); ?>>Từ chối</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-check"></i> Cập nhật trạng thái
                    </button>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/reviews/edit.blade.php ENDPATH**/ ?>