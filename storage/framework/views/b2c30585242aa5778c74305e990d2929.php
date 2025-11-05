<?php $__env->startSection('title', 'Quản Lý Người Dùng'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <h3 class="fw-bold mb-3">Quản Lý Người Dùng</h3>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <form class="row mb-3" method="GET">
            <div class="col-md-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control"
                    placeholder="Tìm kiếm theo tên hoặc email...">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Họ Tên</th>
                            <th>SĐT</th>
                            <th>Quyền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->full_name); ?></td>
                                <td><?php echo e($user->phone ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'secondary'); ?>">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($user->status === 'active' ? 'success' : 'warning'); ?>">
                                        <?php echo e(ucfirst($user->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($user->created_at->format('d/m/Y H:i')); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="d-inline"
                                        onsubmit="return confirm('Xóa người dùng này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($users->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/users/index.blade.php ENDPATH**/ ?>