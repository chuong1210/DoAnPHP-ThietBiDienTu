<?php $__env->startSection('title', 'Quản Lý Đơn Hàng'); ?>
<?php $__env->startSection('page-title', 'Quản Lý Đơn Hàng'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Thẻ thống kê nhanh */
    .stat-card {
        background-color: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--neutral);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 102, 255, 0.1);
    }
    .stat-card .stat-icon {
        position: absolute;
        top: 50%;
        right: 1.5rem;
        transform: translateY(-50%);
        font-size: 3.5rem;
        opacity: 0.1;
        transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon {
        transform: translateY(-50%) scale(1.1);
        opacity: 0.15;
    }
    .stat-card h6 {
        font-weight: 600;
        color: #64748B;
    }
    .stat-card h2 {
        font-weight: 800;
        color: var(--text);
    }
    .stat-card.primary h2, .stat-card.primary .stat-icon { color: var(--primary); }
    .stat-card.secondary h2, .stat-card.secondary .stat-icon { color: var(--secondary); }
    .stat-card.warning h2, .stat-card.warning .stat-icon { color: #F59E0B; }
    .stat-card.success h2, .stat-card.success .stat-icon { color: #10B981; }

    /* Bảng dữ liệu */
    .table thead th {
        background-color: var(--background);
        font-weight: 600;
        white-space: nowrap;
    }
    .table tbody tr:hover {
        background-color: var(--background);
    }
    .order-number {
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
    }
    .order-number:hover {
        color: var(--secondary);
    }

    /* Badge Trạng thái */
    .status-badge {
        font-size: 0.8rem;
        padding: 0.4em 0.9em;
        border-radius: 20px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-badge-pending { background-color: #FEF3C7; color: #92400E; }
    .status-badge-confirmed { background-color: #DBEAFE; color: #1E40AF; }
    .status-badge-shipping { background-color: #D1FAE5; color: #065F46; }
    .status-badge-delivered { background-color: #E0E7FF; color: #3730A3; }
    .status-badge-cancelled { background-color: #FEE2E2; color: #991B1B; }
    .status-badge-paid { background-color: #D1FAE5; color: #065F46; }
    .status-badge-failed { background-color: #FEE2E2; color: #991B1B; }

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Thống kê nhanh -->
<div class="row">
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card primary">
            <h6>Tổng Đơn Hàng</h6>
            <h2><?php echo e($stats['total_orders'] ?? 0); ?></h2>
            <div class="stat-icon"><i class="fas fa-receipt"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card warning">
            <h6>Chờ Xử Lý</h6>
            <h2><?php echo e($stats['pending_orders'] ?? 0); ?></h2>
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card success">
            <h6>Doanh Thu Tháng</h6>
            <h2 class="h4"><?php echo e(number_format($stats['monthly_revenue'] ?? 0)); ?>đ</h2>
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stat-card secondary">
            <h6>Đang Giao</h6>
            <h2><?php echo e($stats['shipping_orders'] ?? 0); ?></h2>
            <div class="stat-icon"><i class="fas fa-truck"></i></div>
        </div>
    </div>
</div>

<!-- Bộ lọc và Bảng đơn hàng -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tất Cả Đơn Hàng</h5>
    </div>
    <div class="card-body">
        <!-- Filter form -->
        <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm theo mã đơn, tên, SĐT..." value="<?php echo e(request('keyword')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Chờ xử lý</option>
                        <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Đã xác nhận</option>
                        <option value="shipping" <?php echo e(request('status') == 'shipping' ? 'selected' : ''); ?>>Đang giao</option>
                        <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Đã giao</option>
                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary w-100"><i class="fas fa-sync-alt"></i></a>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th class="text-center">Thanh Toán</th>
                        <th class="text-center">Trạng Thái</th>
                        <th class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="order-number">
                                    <?php echo e($order->order_number); ?>

                                </a>
                            </td>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            <td><strong><?php echo e(number_format($order->total)); ?>đ</strong></td>
                            <td class="text-center">
                                <?php if($order->payment_status == 'paid'): ?>
                                    <span class="status-badge status-badge-paid">Đã trả</span>
                                <?php elseif($order->payment_status == 'failed'): ?>
                                     <span class="status-badge status-badge-failed">Thất bại</span>
                                <?php else: ?>
                                     <span class="status-badge status-badge-pending">Chưa trả</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="status-badge status-badge-<?php echo e($order->status); ?>"><?php echo e($order->status); ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <p class="text-muted mb-0">Không có đơn hàng nào.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($orders->hasPages()): ?>
            <div class="mt-4">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>