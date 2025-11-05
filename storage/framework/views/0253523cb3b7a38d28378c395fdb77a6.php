<?php $__env->startSection('title', 'Thêm Sản Phẩm Mới'); ?>
<?php $__env->startSection('page-title', 'Thêm Sản Phẩm Mới'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* === PAGE HEADER === */
        .page-header {
            background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .breadcrumb {
            background: transparent;
            margin: 0.5rem 0 0 0;
            padding: 0;
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb-item.active {
            color: white;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.6);
        }

        /* === CARDS === */
        .card {
            border: 1px solid #CBD5E1;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(30, 41, 59, 0.04);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #F8FAFC;
            border-bottom: 1px solid #CBD5E1;
            padding: 1.25rem 1.5rem;
            border-radius: 16px 16px 0 0;
        }

        .card-header h5 {
            margin: 0;
            color: #1E293B;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* === FORM ELEMENTS === */
        .form-label {
            color: #1E293B;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9375rem;
        }

        .form-label .text-danger {
            color: #DC2626 !important;
        }

        .form-control,
        .form-select {
            background: white;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            padding: 0.625rem 1rem;
            font-size: 0.9375rem;
            color: #1E293B;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0066FF;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
            background: white;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #DC2626;
        }

        .form-control.is-invalid:focus,
        .form-select.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .invalid-feedback {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        /* === IMAGE UPLOADER === */
        .image-uploader {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            cursor: pointer;
            background: #F8FAFC;
            transition: all 0.3s ease;
            position: relative;
        }

        .image-uploader:hover {
            border-color: #0066FF;
            background: white;
        }

        .image-uploader .upload-icon {
            font-size: 3rem;
            color: #00B4D8;
            margin-bottom: 0.75rem;
        }

        .image-uploader .upload-text {
            color: #64748B;
            margin: 0;
            font-size: 0.9375rem;
        }

        .image-uploader .upload-hint {
            color: #94A3B8;
            font-size: 0.8125rem;
            margin: 0.5rem 0 0 0;
        }

        /* === IMAGE PREVIEW === */
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #CBD5E1;
            background: #F8FAFC;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item .remove-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 28px;
            height: 28px;
            background: #DC2626;
            color: white;
            border: 2px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease;
        }

        .preview-item .remove-btn:hover {
            background: #B91C1C;
            transform: scale(1.1);
        }

        /* === FORM CHECK === */
        .form-check {
            padding-left: 33px;
        }

        .form-check-input {
            width: 3rem;
            height: 1.5rem;
            background-color: #CBD5E1;
            border: none;
            border-radius: 2rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: #0066FF;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        .form-check-label {
            margin-left: 0.75rem;
            color: #1E293B;
            font-weight: 600;
        }

        /* === BUTTONS === */
        .btn {
            border-radius: 10px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #0066FF;
            color: white;
        }

        .btn-primary:hover {
            background: #0052CC;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .btn-secondary {
            background: white;
            border: 1px solid #CBD5E1;
            color: #64748B;
        }

        .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #0066FF;
            color: #0066FF;
        }

        /* === ALERT === */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
        }

        .alert-danger h5 {
            color: #991B1B;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        /* === SELECT DROPDOWN === */
        select.form-select {
            cursor: pointer;
        }

        /* === NUMBER INPUT === */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-plus-circle me-2"></i>Thêm Sản Phẩm Mới</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('admin.products.index')); ?>" style="color: rgba(255,255,255,0.8);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </nav>
    </div>

    <!-- Error Display -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-circle me-2"></i>Có lỗi xảy ra:</h5>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle me-2"></i>Thông Tin Cơ Bản</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Tên Sản Phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name')); ?>"
                                   placeholder="VD: iPhone 15 Pro Max 256GB">
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
                            <label class="form-label">Mô Tả Chi Tiết</label>
                            <textarea name="description"
                                      class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="6"
                                      placeholder="Nhập mô tả chi tiết về sản phẩm, tính năng, ưu điểm..."><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
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

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Giá Gốc (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price"
                                       class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('price')); ?>"
                                       placeholder="0"
                                       step="1000">
                                <?php $__errorArgs = ['price'];
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Giá Khuyến Mãi (VNĐ)</label>
                                <input type="number" name="sale_price"
                                       class="form-control <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('sale_price')); ?>"
                                       placeholder="0"
                                       step="1000">
                                <?php $__errorArgs = ['sale_price'];
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Số Lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity"
                                       class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('quantity', 0)); ?>"
                                       placeholder="0">
                                <?php $__errorArgs = ['quantity'];
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
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-images me-2"></i>Hình Ảnh Sản Phẩm</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Ảnh Đại Diện <span class="text-danger">*</span></label>
                            <div class="image-uploader" onclick="document.getElementById('main-image').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <p class="upload-text">Nhấn để tải lên ảnh đại diện</p>
                                <p class="upload-hint">Định dạng: JPG, PNG. Kích thước tối đa: 2MB</p>
                            </div>
                            <input type="file" id="main-image" name="image"
                                   class="d-none <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept="image/*">
                            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div id="main-image-preview" class="image-preview-container"></div>
                        </div>

                        <div>
                            <label class="form-label">Ảnh Bổ Sung (Tối đa 5 ảnh)</label>
                            <div class="image-uploader" onclick="document.getElementById('extra-images').click()">
                                <i class="fas fa-images upload-icon"></i>
                                <p class="upload-text">Nhấn để tải lên nhiều ảnh</p>
                                <p class="upload-hint">Có thể chọn nhiều ảnh cùng lúc</p>
                            </div>
                            <input type="file" id="extra-images" name="images[]"
                                   class="d-none"
                                   accept="image/*"
                                   multiple>
                            <div id="extra-images-preview" class="image-preview-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Category & Brand -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-tags me-2"></i>Phân Loại</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Danh Mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Chọn danh mục --</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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

                        <div>
                            <label class="form-label">Thương Hiệu <span class="text-danger">*</span></label>
                            <select name="brand_id" class="form-select <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Chọn thương hiệu --</option>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>"
                                        <?php echo e(old('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                        <?php echo e($brand->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['brand_id'];
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
                    </div>
                </div>

                <!-- Status & Features -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-cog me-2"></i>Cài Đặt</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="active" <?php echo e(old('status', 'active') == 'active' ? 'selected' : ''); ?>>
                                    Hoạt động (Đang bán)
                                </option>
                                <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>
                                    Không hoạt động (Ngừng bán)
                                </option>
                            </select>
                            <?php $__errorArgs = ['status'];
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

                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_featured" value="1"
                                   class="form-check-input"
                                   id="is_featured"
                                   <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_featured">
                                Đánh dấu là sản phẩm nổi bật
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Lưu Sản Phẩm
                            </button>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy Bỏ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Preview main image
        document.getElementById('main-image').addEventListener('change', function(e) {
            const preview = document.getElementById('main-image-preview');
            preview.innerHTML = '';

            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    item.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                    preview.appendChild(item);
                }
                reader.readAsDataURL(file);
            }
        });

        // Preview extra images
        document.getElementById('extra-images').addEventListener('change', function(e) {
            const preview = document.getElementById('extra-images-preview');
            preview.innerHTML = '';

            const files = e.target.files;
            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const item = document.createElement('div');
                        item.className = 'preview-item';
                        item.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                        preview.appendChild(item);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/products/create.blade.php ENDPATH**/ ?>