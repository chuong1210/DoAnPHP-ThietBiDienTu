<?php $__env->startSection('title', 'Thêm FAQ'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Thêm Câu Hỏi Thường Gặp</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 650px; margin: 0 auto;">
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.faqs.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <!-- Câu hỏi -->
                <div class="mb-3">
                    <label for="question" class="form-label fw-500" style="color: #1E293B;">Câu hỏi <span class="text-danger">*</span></label>
                    <input type="text" name="question" id="question" class="form-control <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('question')); ?>" style="border-color: #F0D9DE;" required>
                    <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Câu trả lời -->
                <div class="mb-3">
                    <label for="answer" class="form-label fw-500" style="color: #1E293B;">Câu trả lời <span class="text-danger">*</span></label>
                    <textarea name="answer" id="answer" rows="6" class="form-control <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" style="border-color: #F0D9DE;" required><?php echo e(old('answer')); ?></textarea>
                    <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Danh mục với Icon -->
                <div class="mb-3">
                    <label for="category" class="form-label fw-500" style="color: #1E293B;">Danh mục</label>
                    <select name="category" id="category" class="form-select select2-category" style="width: 100%;">
                        <option value="">-- Chọn danh mục --</option>
                        <?php
                            $categories = ['Đặt hàng', 'Thanh toán', 'Giao hàng', 'Bảo hành', 'Đổi trả'];
                            $icons = [
                                'Đặt hàng'   => 'fas fa-shopping-bag',
                                'Thanh toán' => 'fas fa-credit-card',
                                'Giao hàng'  => 'fas fa-truck',
                                'Bảo hành'   => 'fas fa-shield-alt',
                                'Đổi trả'    => 'fas fa-exchange-alt',
                            ];
                        ?>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat); ?>" data-icon="<?php echo e($icons[$cat] ?? 'fas fa-question-circle'); ?>" <?php echo e(old('category') == $cat ? 'selected' : ''); ?>>
                                <?php echo e($cat); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Kích hoạt -->
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?> style="accent-color: #FF3B3F;">
                    <label for="is_active" class="form-check-label" style="color: #1E293B;">Kích hoạt ngay</label>
                </div>

                <!-- Thứ tự -->
                <div class="mb-4">
                    <label for="sort_order" class="form-label fw-500" style="color: #1E293B;">Thứ tự sắp xếp</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e(old('sort_order', 0)); ?>" min="0" style="border-color: #F0D9DE;">
                </div>

                <!-- Nút -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-save"></i> Lưu FAQ
                    </button>
                    <a href="<?php echo e(route('admin.faqs.index')); ?>" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--single {
    height: 38px !important;
    border: 1px solid #F0D9DE !important;
    border-radius: 0.375rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 12px;
    color: #1E293B;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
.select2-results__option {
    padding: 8px 12px;
}
.select2-results__option i {
    width: 20px;
    text-align: center;
    margin-right: 8px;
    color: #FF3B3F;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function formatCategory(state) {
        if (!state.id) return state.text;

        const icon = $(state.element).data('icon');
        return $('<span><i class="' + icon + '"></i>' + state.text + '</span>');
    }

    $('.select2-category').select2({
        templateResult: formatCategory,
        templateSelection: formatCategory,
        escapeMarkup: function(m) { return m; },
        width: '100%'
    });

    // Giữ giá trị khi validate lỗi
    <?php if(old('category')): ?>
        $('#category').val('<?php echo e(old('category')); ?>').trigger('change');
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/faqs/create.blade.php ENDPATH**/ ?>