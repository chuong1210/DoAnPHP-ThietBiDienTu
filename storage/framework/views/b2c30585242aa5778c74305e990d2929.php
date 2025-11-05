<?php $__env->startSection('title', 'Quản Lý Người Dùng'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div
                    style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); padding: 30px; border-radius: 12px; color: white;">
                    <h2 class="fw-bold mb-1" style="font-size: 28px;">👥 Quản Lý Người Dùng</h2>
                    <p style="margin: 0; opacity: 0.95;">Quản lý tài khoản và quyền người dùng hệ thống</p>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        

        <!-- Search Form -->
        <form class="row mb-4 g-2" method="GET">
            <div class="col-md-6">
                <div class="input-group" style="border-radius: 8px; overflow: hidden;">
                    <span class="input-group-text"
                        style="background-color: #F8FAFC; border: 1px solid #CBD5E1; color: #0066FF;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control"
                        placeholder="Tìm kiếm theo tên hoặc email..."
                        style="border: 1px solid #CBD5E1; background-color: #F8FAFC;">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn w-100" style="background-color: #0066FF; color: white; border: none; font-weight: 600;">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>

        <!-- Users Table Card -->
        <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 4px solid #0066FF;">
            <div class="card-header" style="background-color: #F8FAFC; border-bottom: 1px solid #CBD5E1; padding: 20px;">
                <h5 class="mb-0" style="color: #1E293B; font-weight: 600;">
                    <i class="fas fa-users" style="color: #0066FF; margin-right: 8px;"></i>Danh Sách Người Dùng
                </h5>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr style="background-color: #F8FAFC; border-bottom: 2px solid #CBD5E1;">
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">ID</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Email</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Họ Tên</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">SĐT</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Quyền</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Trạng Thái</th>
                                <th style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Ngày Tạo</th>
                                <th class="text-center"
                                    style="color: #1E293B; font-weight: 600; padding: 15px; border: none;">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid #CBD5E1; transition: background-color 0.2s;">
                                    <td style="color: #1E293B; padding: 15px; vertical-align: middle;"><?php echo e($user->id); ?></td>
                                    <td style="color: #1E293B; padding: 15px; vertical-align: middle;"><?php echo e($user->email); ?></td>
                                    <td style="color: #1E293B; padding: 15px; vertical-align: middle; font-weight: 500;">
                                        <?php echo e($user->full_name); ?></td>
                                    <td style="color: #1E293B; padding: 15px; vertical-align: middle;"><?php echo e($user->phone ?? '-'); ?>

                                    </td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge"
                                            style="background-color: <?php echo e($user->role === 'admin' ? '#0066FF' : '#00B4D8'); ?>; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                            <i class="fas <?php echo e($user->role === 'admin' ? 'fa-crown' : 'fa-user'); ?>"></i>
                                            <?php echo e(ucfirst($user->role)); ?>

                                        </span>
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <span class="badge"
                                            style="background-color: <?php echo e($user->status === 'active' ? '#10B981' : '#F59E0B'); ?>; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 500;">
                                            <i
                                                class="fas <?php echo e($user->status === 'active' ? 'fa-check-circle' : 'fa-clock'); ?>"></i>
                                            <?php echo e(ucfirst($user->status)); ?>

                                        </span>
                                    </td>
                                    <td style="color: #1E293B; padding: 15px; vertical-align: middle;">
                                        <?php echo e($user->created_at->format('d/m/Y H:i')); ?></td>
                                    <td class="text-center" style="padding: 15px; vertical-align: middle;">
                                        <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm"
                                            style="background-color: #0066FF; color: white; border: none; border-radius: 6px; padding: 8px 12px; transition: all 0.2s;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST"
                                            class="d-inline" onsubmit="return confirm('Xóa người dùng này?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm"
                                                style="background-color: #EF4444; color: white; border: none; border-radius: 6px; padding: 8px 12px; transition: all 0.2s;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer" style="background-color: #F8FAFC; border-top: 1px solid #CBD5E1; padding: 20px;">
                <?php echo e($users->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/users/index.blade.php ENDPATH**/ ?>