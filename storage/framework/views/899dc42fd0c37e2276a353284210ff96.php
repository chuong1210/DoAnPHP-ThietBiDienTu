<?php $__env->startSection('title', 'Chỉnh Sửa Danh Mục'); ?>
<?php $__env->startSection('page-title', 'Chỉnh Sửa Danh Mục'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .form-control,
        .form-select,
        .form-check-input {
            border-color: var(--border-color);
            background-color: var(--bg-white);
            border-radius: 10px;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .form-control:focus,
        .form-select:focus,
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
            color: rgb(18, 106, 238);

            border: none;
        }

        .btn-cancel {
            background-color: var(--bg-white);
            border: 2px solid var(--border-color);
        }

        .image-uploader {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            background-color: var(--bg-main);
            text-align: center;
            cursor: pointer;
            position: relative;
        }

        .image-uploader img {
            max-height: 150px;
            border-radius: 10px;
        }

        .image-uploader .placeholder {
            color: var(--text-muted);
        }

        .form-switch .form-check-input {
            width: 50px;
            height: 28px;
            border-radius: 28px;
            background-color: rgba(18, 124, 237, 0.785);
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(255, 59, 63, 0.2);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

        .form-switch .form-check-input:checked {
            background-color: #f0f0f0;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

        .form-switch .form-check-label {
            padding-left: 1rem;
            color: #00000;
            cursor: pointer;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cập nhật: <?php echo e($category->name); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.categories.update', $category->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Tên Danh Mục -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Tên Danh Mục <span
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
                                value="<?php echo e(old('name', $category->name)); ?>" required>
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


                        <div class="mb-4">
                            <label for="parent_id" class="form-label fw-bold">Danh Mục Cha (tùy chọn)</label>
                            <select name="parent_id" id="parent_id"
                                class="form-select <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Chọn danh mục cha --</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id', $category->parent_id) == $parent->id ?
                                    'selected' : ''); ?>>
                                                            <?php echo e($parent->name); ?>

                                                        </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['parent_id'];
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


                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh Đại Diện (tùy chọn)</label>
                            <div class="image-uploader" onclick="document.getElementById('image').click()">
                                <img id="image-preview" src="<?php echo e($category->image ? asset($category->image) : '#'); ?>"
                                    alt="Xem trước" class="<?php echo e($category->image ? '' : 'd-none'); ?> mb-3">
                                <div id="image-placeholder" class="placeholder <?php echo e($category->image ? 'd-none' : ''); ?>">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                                    <p>Nhấn để thay đổi ảnh</p>
                                </div>
                            </div>
                            <input type="file" id="image" name="image" class="d-none <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                accept="image/*">
                            <small class="form-text text-muted">Bỏ trống nếu không muốn thay đổi ảnh.</small>
                            <?php $__errorArgs = ['image'];
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
                        <!-- Trạng Thái -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Trạng Thái</label>
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1" <?php echo e(old('is_active', $category->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">Kích hoạt hiển thị</glabel>
                            </div>
                            <small class="form-text text-muted">Khi được kích hoạt, danh mục này sẽ hiển thị trên trang
                                web.</small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-cancel">Hủy</a>
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
        // Script xem trước ảnh cho phần mở rộng
        document.getElementById('image')?.addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>