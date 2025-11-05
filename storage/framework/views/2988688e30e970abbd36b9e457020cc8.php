<?php $__env->startSection('title', 'Thêm Đánh Giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Updated header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">➕ Thêm Đánh Giá</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <form action="<?php echo e(route('admin.reviews.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label for="comment" class="form-label" style="color: #1E293B; font-weight: 500;">Nội dung <span style="color: #FF3B3F;">*</span></label>
                    <textarea name="comment" id="comment" class="form-control <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="5" style="border-color: #F0D9DE;"><?php echo e(old('comment')); ?></textarea>
                    <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="user_name" class="form-label" style="color: #1E293B; font-weight: 500;">Tên người dùng <span style="color: #FF3B3F;">*</span></label>
                    <input list="users_list" name="user_name" id="user_name" class="form-control <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('user_name')); ?>" style="border-color: #F0D9DE;" required>
                    <datalist id="users_list">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->name); ?>" data-id="<?php echo e($user->id); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id_hidden">
                    <?php $__errorArgs = ['user_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label" style="color: #1E293B; font-weight: 500;">Sản phẩm <span style="color: #FF3B3F;">*</span></label>
                    <select name="product_id" id="product_id" class="form-control <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-color: #F0D9DE;" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($product->id); ?>" <?php echo e(old('product_id') == $product->id ? 'selected' : ''); ?>><?php echo e($product->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['product_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label" style="color: #1E293B; font-weight: 500;">Điểm đánh giá <span style="color: #FF3B3F;">*</span></label>
                    <select name="rating" id="rating" class="form-control <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-color: #F0D9DE;" required>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(old('rating') == $i ? 'selected' : ''); ?>><?php echo e($i); ?> sao</option>
                        <?php endfor; ?>
                    </select>
                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', 1) ? 'checked' : ''); ?> style="accent-color: #FF3B3F;">
                        <label for="is_active" class="form-check-label" style="color: #1E293B;">Hiển thị</label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                        <i class="fas fa-save"></i> Thêm Đánh Giá
                    </button>
                    <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; text-decoration: none;">
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
        hidden.value = option ? option.dataset.id : '';
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/reviews/create.blade.php ENDPATH**/ ?>