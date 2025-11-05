<?php $__env->startSection('title', 'Sửa FAQ'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background-color: #F8FAFC; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">✏️ Sửa Câu Hỏi Thường Gặp</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 8px; max-width: 650px; margin: 0 auto; background: white;">
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.faqs.update', $faq)); ?>" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Câu hỏi <span class="text-danger">*</span></label>
                    <input type="text" name="question" class="form-control <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('question', $faq->question)); ?>" style="border-color: #CBD5E1;" required>
                    <?php $__errorArgs = ['question'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Câu trả lời <span class="text-danger">*</span></label>
                    <textarea name="answer" rows="6" class="form-control <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                              style="border-color: #CBD5E1;" required><?php echo e(old('answer', $faq->answer)); ?></textarea>
                    <?php $__errorArgs = ['answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Danh mục <span class="text-danger">*</span></label>
                    <select name="category" id="category" class="form-select select2-category" style="width: 100%;" required>
                        <?php
                            $cats = [
                                'order'     => ['name' => 'Đặt hàng',   'icon' => 'fas fa-shopping-bag'],
                                'payment'   => ['name' => 'Thanh toán', 'icon' => 'fas fa-credit-card'],
                                'shipping'  => ['name' => 'Giao hàng',  'icon' => 'fas fa-truck'],
                                'warranty'  => ['name' => 'Bảo hành',   'icon' => 'fas fa-shield-alt'],
                                'return'    => ['name' => 'Đổi trả',    'icon' => 'fas fa-exchange-alt'],
                            ];
                        ?>
                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" data-icon="<?php echo e($cat['icon']); ?>"
                                    <?php echo e(old('category', $faq->category) == $value ? 'selected' : ''); ?>>
                                <?php echo e($cat['name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                           <?php echo e(old('is_active', $faq->is_active) ? 'checked' : ''); ?> style="accent-color: #0066FF;">
                    <label class="form-check-label" style="color: #1E293B;">Kích hoạt</label>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-500" style="color: #1E293B;">Thứ tự sắp xếp</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?php echo e(old('sort_order', $faq->sort_order)); ?>" min="0" style="border-color: #CBD5E1;">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1"
                            style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="<?php echo e(route('admin.faqs.index')); ?>" class="btn"
                       style="background-color: #E0E7FF; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--single { height: 38px !important; border: 1px solid #CBD5E1 !important; border-radius: 0.375rem; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; padding-left: 12px; color: #1E293B; }
.select2-results__option i { width: 20px; text-align: center; margin-right: 8px; color: #0066FF; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const format = state => !state.id ? state.text : $(`<span><i class="${$(state.element).data('icon')}"></i> ${state.text}</span>`);
    $('.select2-category').select2({ templateResult: format, templateSelection: format, escapeMarkup: m => m, width: '100%' });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/faqs/edit.blade.php ENDPATH**/ ?>