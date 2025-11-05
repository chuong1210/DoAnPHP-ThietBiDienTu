<?php $__env->startSection('title', 'Chỉnh Sửa Thương Hiệu'); ?>
<?php $__env->startSection('page-title', 'Chỉnh Sửa Thương Hiệu'); ?>

<?php $__env->startSection('styles'); ?>
    
    <style>
        .form-control,
        .form-check-input {
            border-color: var(--border-color);
            background-color: var(--bg-main);
        }

        .form-control:focus,
        .form-check-input:checked {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 59, 63, 0.1);
            background-color: var(--bg-white);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
        }

        .btn-save {
            background: var(--primary-gradient);
            color: white;
            border: none;
        }

        .btn-cancel {
            background-color: var(--bg-white);
            border: 2px solid var(--border-color);
        }

        #image-preview-container {
            width: 200px;
            height: 200px;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-main);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        #image-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        #image-preview-container .placeholder {
            color: var(--text-muted);
            text-align: center;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cập nhật: <?php echo e($brand->name); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.brands.update', $brand->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Tên Thương Hiệu -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Tên Thương Hiệu <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name', $brand->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
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

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Logo</label>
                            <div id="image-preview-container" onclick="document.getElementById('logo').click()">
                                <img id="image-preview" src="<?php echo e($brand->logo ? asset($brand->logo) : '#'); ?>" alt="Preview"
                                    style="<?php echo e($brand->logo ? 'display: block;' : 'display: none;'); ?>">
                                <div id="image-placeholder" class="placeholder"
                                    style="<?php echo e($brand->logo ? 'display: none;' : 'display: block;'); ?>">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                                    <p>Nhấn để thay đổi</p>
                                </div>
                            </div>
                            <input type="file" id="logo" name="logo" class="d-none <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                accept="image/*">
                            <small class="form-text text-muted">Bỏ trống nếu không muốn thay đổi logo.</small>
                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Trạng Thái -->
                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                                value="1" <?php echo e(old('is_active', $brand->is_active) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="is_active">Kích hoạt</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.brands.index')); ?>" class="btn btn-cancel">Hủy</a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i> Cập Nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.getElementById('logo').addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/brands/edit.blade.php ENDPATH**/ ?>