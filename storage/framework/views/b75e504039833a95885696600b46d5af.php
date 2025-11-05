<?php $__env->startSection('title', 'Chỉnh Sửa Người Dùng'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <h3 class="fw-bold mb-3">Chỉnh Sửa Người Dùng</h3>

        <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo e($user->email); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Họ Tên</label>
                    <input type="text" name="full_name" value="<?php echo e(old('full_name', $user->full_name)); ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Số Điện Thoại</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quyền</label>
                        <select name="role" class="form-select">
                            <option value="user" <?php echo e($user->role === 'user' ? 'selected' : ''); ?>>User</option>
                            <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-select">
                            <option value="active" <?php echo e($user->status === 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e($user->status === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Căn 2 nút trên cùng một hàng -->
                <div class="d-flex justify-content-start gap-2 mt-3">
                    <button class="btn btn-success"><i class="fas fa-save"></i> Lưu Thay Đổi</button>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>