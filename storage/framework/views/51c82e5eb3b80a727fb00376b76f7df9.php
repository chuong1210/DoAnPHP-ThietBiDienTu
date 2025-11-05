<?php $__env->startSection('title', 'Sửa Đánh Giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <!-- Tech Blue header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.2);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
            </svg>
            <h1 class="h3 mb-0">Sửa Đánh Giá</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 700px; margin: 0 auto; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
        <div class="card-body" style="padding: 32px;">
            <form action="<?php echo e(route('admin.reviews.update', $review->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label for="comment" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Nội dung <span style="color: #0066FF;">*</span></label>
                    <textarea name="comment" id="comment" class="form-control <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="5" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;"><?php echo e(old('comment', $review->comment)); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="user_name" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Tên người dùng <span style="color: #0066FF;">*</span></label>
                    <input list="users_list" name="user_name" id="user_name" class="form-control" value="<?php echo e(old('user_name', $review->user_name)); ?>" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" required>
                    <datalist id="users_list">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->name); ?>" data-id="<?php echo e($user->id); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id_hidden" value="<?php echo e($review->user_id); ?>">
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Sản phẩm <span style="color: #0066FF;">*</span></label>
                    <select name="product_id" id="product_id" class="form-control" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" <?php echo e(old('product_id', $review->product_id) == $product->id ? 'selected' : ''); ?>><?php echo e($product->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Điểm đánh giá <span style="color: #0066FF;">*</span></label>
                    <select name="rating" id="rating" class="form-control" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" required>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(old('rating', $review->rating) == $i ? 'selected' : ''); ?>><?php echo e($i); ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', $review->is_active) ? 'checked' : ''); ?> style="accent-color: #0066FF;">
                        <label for="is_active" class="form-check-label" style="color: #1E293B;">Hiển thị</label>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-save"></i> Cập nhật Đánh Giá
                    </button>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn" style="background-color: #E0F2FE; color: #0066FF; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const input = document.getElementById('user_name');
    const hidden = document.getElementById('user_id_hidden');

    input.addEventListener('input', function() {
        const option = Array.from(document.getElementById('users_list').options)
                            .find(o => o.value === input.value);
        hidden.value = option ? option.dataset.id : '' || hidden.value;
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/reviews/edit.blade.php ENDPATH**/ ?>