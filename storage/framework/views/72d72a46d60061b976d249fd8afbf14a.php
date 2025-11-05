<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu - Tech Shop</title>
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
        }

        .brand-logo i {
            font-size: 3.5rem;
            color: var(--primary);
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 102, 255, 0.1);
            border: 1px solid var(--neutral);
            padding: 2.5rem;
        }

        .form-control {
            border: 2px solid var(--neutral);
            border-radius: 12px;
            padding: 0.75rem 1rem;
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
        }

        /* CSS CHO ICON VÀ TOGGLE */
        .input-wrapper {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .password-toggle-icon:hover {
            color: var(--primary);
        }

        .form-control:read-only {
            background-color: var(--background);
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="brand-logo">
                <i class="fas fa-shield-alt"></i>
                <h2 class="mt-2">Đặt Lại Mật Khẩu</h2>
            </div>
            <div class="login-card">
                <form method="POST" action="<?php echo e(route('password.update')); ?>">
                    <?php echo csrf_field(); ?>

                    
                    <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="email" value="<?php echo e($request->email ?? old('email')); ?>" required readonly>
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

                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Mật khẩu mới</label>
                        <div class="input-wrapper">
                            <input id="password" type="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                            <i class="fas fa-eye password-toggle-icon" data-target="password"></i>
                        </div>
                        <?php $__errorArgs = ['password'];
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

                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu</label>
                        <div class="input-wrapper">
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                            <i class="fas fa-eye password-toggle-icon" data-target="password_confirmation"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="fas fa-save me-2"></i> Đặt Lại Mật Khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleIcons = document.querySelectorAll('.password-toggle-icon');

            toggleIcons.forEach(icon => {
                icon.addEventListener('click', function () {
                    const targetInputId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetInputId);

                    if (targetInput) {
                        const type = targetInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        targetInput.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    }
                });
            });
        });
    </script>
</body>

</html><?php /**PATH C:\Users\chuon\PHP\doanPHP\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>