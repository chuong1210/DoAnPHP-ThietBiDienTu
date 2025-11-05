<?php $__env->startSection('title', 'Thêm Banner'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <!-- Tech Blue gradient header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.2);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            <h1 class="h3 mb-0">Thêm Banner</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 700px; margin: 0 auto; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
        <div class="card-body" style="padding: 32px;">
            <form action="<?php echo e(route('admin.banners.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <!-- Improved form styling with Tech Blue accents -->
                <div class="mb-3">
                    <label for="title" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Tiêu đề <span style="color: #0066FF;">*</span></label>
                    <input type="text" name="title" id="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('title')); ?>" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" placeholder="Nhập tiêu đề banner">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback" style="color: #FF6B68;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Hình ảnh <span style="color: #0066FF;">*</span></label>
                    <input type="file" name="image" id="image" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/jpeg,image/png,image/jpg" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;">
                    <div id="image-preview" class="mt-3" style="display: none;">
                        <img id="preview-img" src="#" alt="Preview" style="max-width: 150px; border-radius: 8px; border: 2px solid #E0F2FE;">
                    </div>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback" style="color: #FF6B68;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Liên kết</label>
                    <input type="url" name="link" id="link" class="form-control <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('link')); ?>" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" placeholder="https://example.com">
                    <?php $__errorArgs = ['link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback" style="color: #FF6B68;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Thứ tự</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e(old('sort_order', 0)); ?>" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" min="0">
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', 1) ? 'checked' : ''); ?> style="border-color: #CBD5E1; accent-color: #0066FF; width: 18px; height: 18px; cursor: pointer;">
                        <label for="is_active" class="form-check-label" style="color: #1E293B; margin-left: 8px; cursor: pointer;">Hiển thị</label>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 500; cursor: pointer;">
                        <i class="fas fa-save"></i> Thêm Banner
                    </button>
                    <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn" style="background-color: #E0F2FE; color: #0066FF; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 500;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImg = document.getElementById('preview-img');
        const previewContainer = document.getElementById('image-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/banners/create.blade.php ENDPATH**/ ?>