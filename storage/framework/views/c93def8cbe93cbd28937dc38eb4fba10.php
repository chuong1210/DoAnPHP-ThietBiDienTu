<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - Tech Shop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
        }

        body {
            background: linear-gradient(135deg, var(--background) 0%, #E0F2FE 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            max-width: 450px;
            margin: 2rem auto;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease;
        }

        .brand-logo i {
            font-size: 3.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 6px rgba(0, 102, 255, 0.2));
        }

        .brand-logo h2 {
            color: var(--text);
            font-weight: 700;
            margin-top: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 102, 255, 0.1);
            border: 1px solid var(--neutral);
            padding: 2.5rem;
            animation: fadeInUp 0.6s ease;
        }

        .form-control {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 102, 255, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 255, 0.4);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            color: #065F46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="brand-logo">
                <i class="fas fa-key"></i>
                <h2 class="mt-2">Quên Mật Khẩu</h2>
            </div>

            <div class="login-card">
                <p class="text-muted text-center mb-4">Đừng lo lắng! Hãy nhập địa chỉ email của bạn và chúng tôi sẽ gửi
                    cho bạn một liên kết để đặt lại mật khẩu.</p>

                <?php if(session('status')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('password.email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Địa chỉ Email</label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                        <?php $__errorArgs = ['email'];
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
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane me-2"></i> Gửi Liên Kết Đặt Lại
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="<?php echo e(route('login')); ?>">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại trang Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>