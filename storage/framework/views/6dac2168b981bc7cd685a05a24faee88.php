 

<?php $__env->startSection('title', 'Xác thực Email'); ?>
<?php
    $hideSidebar = true;
?>
<?php $__env->startSection('content'); ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Xác thực địa chỉ Email của bạn</h4>
                    </div>

                    <div class="card-body">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <p>Trước khi tiếp tục, vui lòng kiểm tra email của bạn để tìm liên kết xác minh.</p>
                        <p>Nếu bạn không nhận được email, hãy nhấn vào nút bên dưới để gửi lại.</p>

                        <form class="d-inline" method="POST" action="<?php echo e(route('verification.send')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                Gửi lại email xác thực
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/auth/verify.blade.php ENDPATH**/ ?>