<?php $__env->startSection('title', 'Xem Đánh Giá #<?php echo e($review->id); ?>'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px;">
        <h1 class="h3 mb-0">Xem Đánh Giá #<?php echo e($review->id); ?></h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 700px; margin: auto;">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Người dùng</label>
                    <p class="mb-0"><?php echo e($review->user_name); ?> <small class="text-muted">(ID: <?php echo e($review->user_id); ?>)</small></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Sản phẩm</label>
                    <p class="mb-0"><?php echo e($review->product->name ?? 'Sản phẩm đã xóa'); ?></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Đánh giá</label>
                    <div style="display: flex; gap: 4px; font-size: 20px;">
                        <?php for($i = 0; $i < $review->rating; $i++): ?>
                            <span style="color: #FFB800;">★</span>
                        <?php endfor; ?>
                        <?php for($i = $review->rating; $i < 5; $i++): ?>
                            <span style="color: #CBD5E1;">★</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Trạng thái</label>
                   <span class="badge" style="
                        background-color:
                            <?php echo e($review->status === 'pending' ? '#F59E0B' :
                            ($review->status === 'approved' ? '#10B981' : '#EF4444')); ?>;
                        color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.8rem;">
                        <?php echo e($review->status === 'pending' ? 'Chưa duyệt' :
                        ($review->status === 'approved' ? 'Đã duyệt' : 'Từ chối')); ?>

                    </span>
                </div>
                <div class="col-12">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Nội dung đánh giá</label>
                    <p class="border p-3 rounded" style="background: #F8FAFC; min-height: 80px;"><?php echo e($review->comment ?: '— Không có nội dung —'); ?></p>
                </div>
                <div class="col-12">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Thời gian</label>
                    <p class="mb-0 text-muted"><?php echo e($review->created_at->format('d/m/Y H:i')); ?></p>
                </div>
            </div>

           <!-- Thay đổi trạng thái (Admin có quyền) -->
        <div class="mt-4">
            <label class="form-label" style="color: #1E293B; font-weight: 600;">Cập nhật trạng thái</label>
            <form action="<?php echo e(route('admin.reviews.updateStatus', $review->id)); ?>" method="POST" class="d-flex gap-2 align-items-center">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <select name="status" class="form-select form-select-sm" style="width: auto; border-color: #CBD5E1; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="pending" <?php echo e($review->status === 'pending' ? 'selected' : ''); ?> style="color: #F59E0B;">Chưa duyệt</option>
                    <option value="approved" <?php echo e($review->status === 'approved' ? 'selected' : ''); ?> style="color: #10B981;">Đã duyệt</option>
                    <option value="rejected" <?php echo e($review->status === 'rejected' ? 'selected' : ''); ?> style="color: #EF4444;">Từ chối</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px; border-radius: 6px;">
                    Cập nhật
                </button>
            </form>
        </div>

            <div class="d-flex gap-2 mt-4">
                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn flex-grow-1" style="background: #E0F2FE; color: #0066FF; border: 1px solid #0066FF;">
                    Quay lại danh sách
                </a>
                <form action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>" method="POST" onsubmit="return confirm('Xóa vĩnh viễn?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger">Xóa đánh giá</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\LTMNM\DoAnPHP-ThietBiDienTu\resources\views/admin/reviews/show.blade.php ENDPATH**/ ?>