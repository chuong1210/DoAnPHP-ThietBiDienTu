<?php $__env->startSection('title', 'Chỉnh Sửa Sản Phẩm'); ?>
<?php $__env->startSection('page-title', 'Chỉnh Sửa Sản Phẩm'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Sử dụng lại style từ create.blade.php */
        .page-header {
            background: linear-gradient(135deg, #00B4D8 0%, #0066FF 100%);
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

        .invalid-feedback {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .image-uploader {
            border: 2px dashed #CBD5E1;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            cursor: pointer;
            background: #F8FAFC;
            transition: all 0.3s ease;
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

        .btn-danger {
            background: #DC2626;
            color: white;
        }

        .btn-danger:hover {
            background: #B91C1C;
            transform: translateY(-1px);
        }

        .product-id-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.875rem;
            margin-left: 1rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>
                    <i class="fas fa-edit me-2"></i>Chỉnh Sửa Sản Phẩm
                    <span class="product-id-badge">#<?php echo e($product->id); ?></span>
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" style="color: rgba(255,255,255,0.8);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.products.index')); ?>" style="color: rgba(255,255,255,0.8);">Sản phẩm</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>
            <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Xóa Sản Phẩm
                </button>
            </form>
        </div>
    </div>

    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

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
                                   value="<?php echo e(old('name', $product->name)); ?>">
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
                                      rows="6"><?php echo e(old('description', $product->description)); ?></textarea>
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
                                       value="<?php echo e(old('price', $product->price)); ?>"
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
                                       value="<?php echo e(old('sale_price', $product->sale_price)); ?>"
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
                                       value="<?php echo e(old('quantity', $product->quantity)); ?>">
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
                            <label class="form-label">Ảnh Đại Diện</label>
                            <div class="image-uploader" onclick="document.getElementById('main-image').click()">
                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                <p class="upload-text">Nhấn để thay đổi ảnh đại diện</p>
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
                            <div id="main-image-preview" class="image-preview-container">
                                <?php if($product->image): ?>
                                    <div class="preview-item">
                                        <img src="<?php echo e(asset($product->image)); ?>" alt="Current Image">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Ảnh Bổ Sung</label>
                            <div class="image-uploader" onclick="document.getElementById('extra-images').click()">
                                <i class="fas fa-images upload-icon"></i>
                                <p class="upload-text">Nhấn để tải thêm ảnh mới</p>
                            </div>
                            <input type="file" id="extra-images" name="images[]"
                                   class="d-none"
                                   accept="image/*"
                                   multiple>
                            <div id="extra-images-preview" class="image-preview-container">
                                <?php if(is_array($product->images) && !empty($product->images)): ?>
                                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="preview-item">
                                            <img src="<?php echo e(asset($img)); ?>" alt="Extra Image">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
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
                                        <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
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
                                        <?php echo e(old('brand_id', $product->brand_id) == $brand->id ? 'selected' : ''); ?>>
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
                            <select name="status" class="form-select">
                                <option value="active" <?php echo e(old('status', $product->status) == 'active' ? 'selected' : ''); ?>>
                                    Hoạt động (Đang bán)
                                </option>
                                <option value="inactive" <?php echo e(old('status', $product->status) == 'inactive' ? 'selected' : ''); ?>>
                                    Không hoạt động (Ngừng bán)
                                </option>
                            </select>
                        </div>

                        <div class="form-check form-switch mb-4 ml-10">
                            <input type="checkbox" name="is_featured" value="1"
                                   class="form-check-input"
                                   id="is_featured"
                                   <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>>
                            <label class="form-check-label " for="is_featured">
                                Đánh dấu là sản phẩm nổi bật
                            </label>
                        </div>

                        <div style="padding: 1rem; background: #F8FAFC; border-radius: 10px; font-size: 0.875rem; color: #64748B;">
                            <p style="margin: 0 0 0.5rem 0;"><strong>Thống kê:</strong></p>
                            <p style="margin: 0;">Lượt xem: <strong><?php echo e($product->view_count); ?></strong></p>
                            <p style="margin: 0;">Đã bán: <strong><?php echo e($product->sold_count); ?></strong></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Cập Nhật Sản Phẩm
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
        // Preview main image when changed
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

        // Preview extra images when changed
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

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>