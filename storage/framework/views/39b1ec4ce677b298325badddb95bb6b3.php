<?php $__env->startSection('title', 'Quản Lý Đánh Giá'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <!-- Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.2);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <h1 class="h3 mb-0">Quản Lý Đánh Giá</h1>
        </div>
    </div>

    <!-- Lọc trạng thái -->
    <div class="mb-4 d-flex gap-3 align-items-center flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <label class="form-label mb-0" style="color: #1E293B; font-weight: 500; white-space: nowrap;">Lọc theo trạng thái:</label>
            <select id="status-filter" class="form-select" style="width: auto; min-width: 200px; border-color: #CBD5E1; border-radius: 8px;">
                <option value="">Tất cả</option>
                <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Chờ duyệt</option>
                <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Đã duyệt</option>
                <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Từ chối</option>
            </select>
        </div>
        <button id="clear-status-filter" class="btn btn-outline-secondary" style="border-color: #CBD5E1; color: #64748B; padding: 6px 16px; border-radius: 8px; display: none;">
            Xóa lọc
        </button>
    </div>

    <!-- JS Lọc trạng thái -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status-filter');
            const clearStatusBtn = document.getElementById('clear-status-filter');
            const currentUrl = new URL(window.location);

            if (statusSelect) {
                statusSelect.addEventListener('change', function () {
                    const val = this.value;
                    if (val) {
                        currentUrl.searchParams.set('status', val);
                    } else {
                        currentUrl.searchParams.delete('status');
                    }
                    window.location = currentUrl;
                });

                if (statusSelect.value) {
                    clearStatusBtn.style.display = 'inline-flex';
                }

                clearStatusBtn.addEventListener('click', function () {
                    currentUrl.searchParams.delete('status');
                    window.location = currentUrl;
                });
            }
        });
    </script>

    <!-- Bảng đánh giá -->
    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-color: #CBD5E1;">
                    <thead style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white;">
                        <tr>
                            <th style="padding: 16px; font-weight: 600;">ID</th>
                            <th style="padding: 16px; font-weight: 600;">Người dùng</th>
                            <th style="padding: 16px; font-weight: 600;">Sản phẩm</th>
                            <th style="padding: 16px; font-weight: 600;">Đánh giá</th>
                            <th style="padding: 16px; font-weight: 600;">Nội dung</th>
                            <th style="padding: 16px; font-weight: 600;">Trạng thái</th>
                            <th style="padding: 16px; font-weight: 600;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #CBD5E1;">
                                <td style="color: #1E293B; padding: 16px;">#<?php echo e($review->id); ?></td>
                                <td style="color: #1E293B; font-weight: 500; padding: 16px;">
                                    <?php echo e($review->user_name); ?>

                                    <small class="d-block text-muted">ID: <?php echo e($review->user_id); ?></small>
                                </td>
                                <td style="color: #1E293B; padding: 16px;">
                                    <?php echo e($review->product->name ?? 'Sản phẩm đã xóa'); ?>

                                </td>
                                <td style="padding: 16px;">
                                    <div style="display: flex; gap: 2px; font-size: 16px;">
                                        <?php for($i = 0; $i < $review->rating; $i++): ?>
                                            <span style="color: #FFB800;">★</span>
                                        <?php endfor; ?>
                                        <?php for($i = $review->rating; $i < 5; $i++): ?>
                                            <span style="color: #CBD5E1;">★</span>
                                        <?php endfor; ?>
                                    </div>
                                </td>
                                <td style="padding: 16px; max-width: 300px;">
                                    <p class="text-muted mb-0" style="font-size: 0.875rem; line-height: 1.4;">
                                        <?php echo e(Str::limit($review->comment, 80)); ?>

                                    </p>
                                </td>
                                <td style="padding: 16px;">
                                    <span class="badge" style="
                                        background-color:
                                            <?php echo e($review->status === 'pending' ? '#F59E0B' :
                                               ($review->status === 'approved' ? '#10B981' : '#EF4444')); ?>;
                                        color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.8rem;">
                                        <?php echo e($review->status === 'pending' ? 'Chưa duyệt' :
                                           ($review->status === 'approved' ? 'Đã duyệt' : 'Từ chối')); ?>

                                    </span>
                                </td>
                                <td style="padding: 16px; display: flex; gap: 8px; align-items: center;">
                                    <!-- Xem -->
                                    <a href="<?php echo e(route('admin.reviews.show', $review->id)); ?>" class="btn btn-sm" style="background: #0066FF; color: white; padding: 6px 12px; border-radius: 6px;" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Xóa -->
                                    <form action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Xóa đánh giá này vĩnh viễn?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" style="padding: 6px 12px; border-radius: 6px;" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center" style="color: #64748B; padding: 40px;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <p class="mb-0">Chưa có đánh giá nào</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="px-4 py-3 bg-white border-top" style="border-color: #CBD5E1;">
                <?php echo e($reviews->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>

<!-- JS Lọc sản phẩm -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('product-filter');
        const clearBtn = document.getElementById('clear-filter');
        const currentUrl = new URL(window.location);

        if (select) {
            select.addEventListener('change', function () {
                const val = this.value;
                if (val) {
                    currentUrl.searchParams.set('product_id', val);
                } else {
                    currentUrl.searchParams.delete('product_id');
                }
                window.location = currentUrl;
            });

            if (select.value) {
                clearBtn.style.display = 'inline-flex';
            }

            clearBtn.addEventListener('click', function () {
                currentUrl.searchParams.delete('product_id');
                window.location = currentUrl;
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>