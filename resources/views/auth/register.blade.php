{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Tech Shop</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066FF;
            --secondary: #00B4D8;
            --background: #F8FAFC;
            --text: #1E293B;
            --neutral: #CBD5E1;
            --danger: #EF4444;
        }

        body {
            background: linear-gradient(135deg, var(--background) 0%, #E0F2FE 100%);
            min-height: 100vh;
            padding: 2rem 0;
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .register-container {
            max-width: 550px;
            margin: 0 auto;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease-out;
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

        .brand-logo p {
            color: #64748B;
            font-size: 0.9rem;
        }

        .register-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 102, 255, 0.1);
            border: 1px solid var(--neutral);
            padding: 2.5rem;
            animation: fadeInUp 0.6s ease-out;
        }

        .form-label {
            color: var(--text);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
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

        .btn-google {
            border: 2px solid var(--neutral);
            background: white;
            color: var(--text);
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-google:hover {
            border-color: var(--primary);
            background: var(--background);
            transform: translateY(-2px);
        }

        .btn-google i {
            color: #EA4335;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--neutral);
        }

        .divider span {
            padding: 0 1rem;
            color: #64748B;
            font-size: 0.85rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2, #FECACA);
            color: #991B1B;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--secondary);
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

        .input-icon {
            position: relative;
        }

        .input-icon .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            pointer-events: none;
        }

        .input-icon .form-control {
            padding-left: 2.75rem;
        }

        /* CSS cho nút toggle mật khẩu */
        .password-toggle-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 5px;
            /* Tăng vùng click */
        }

        .password-toggle-icon:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-container">
            <!-- Brand Logo -->
            <div class="brand-logo">
                <i class="fas fa-microchip"></i>
                <h2>Tech Shop</h2>
                <p>Tạo tài khoản và khám phá công nghệ</p>
            </div>

            <!-- Register Card -->
            <div class="register-card">
                <h4 class="text-center mb-4" style="color: var(--text); font-weight: 700;">Đăng Ký Tài Khoản</h4>

                {{-- @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Họ tên -->
                    <!-- Họ tên -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Họ và tên <span
                                class="text-danger">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-id-card form-icon"></i>
                            <input type="text" name="full_name"
                                class="form-control @error('full_name') is-invalid @enderror"
                                value="{{ old('full_name') }}" placeholder="Nguyễn Văn A" required>
                        </div>
                        @error('full_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-1"></i> Email <span
                                class="text-danger">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-at form-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="your.email@example.com" required>
                        </div>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <!-- Số điện thoại -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone me-1"></i> Số điện thoại <span
                                class="text-danger">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-mobile-alt form-icon"></i>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="0912345678" required>
                        </div>
                        @error('phone')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Mật khẩu <span
                                class="text-danger">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-key form-icon"></i>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Tối thiểu 8 ký tự, gồm chữ hoa, số, ký tự đặc biệt" required>
                            <i class="fas fa-eye password-toggle-icon" data-target="password"></i>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <!-- Xác nhận mật khẩu -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-shield-alt me-1"></i> Xác nhận mật khẩu <span
                                class="text-danger">*</span></label>
                        <div class="input-icon">
                            <i class="fas fa-check-circle form-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Nhập lại mật khẩu" required>
                            <i class="fas fa-eye password-toggle-icon" data-target="password_confirmation"></i>
                        </div>
                    </div>

                    <div class="mb-3 ">
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                            @if($errors->has('g-recaptcha-response'))
                                <div class="server-error">{{ $errors->first('g-recaptcha-response') }}</div>
                            @endif
                        </div>

                        <!-- Điều khoản -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms" style="font-weight: 500;">
                                Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a>
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i> Đăng Ký
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>hoặc đăng ký với</span>
                        </div>

                        <!-- Google Register -->
                        <a href="{{ route('auth.google') }}" class="btn btn-google w-100">
                            <i class="fab fa-google me-2"></i> Đăng Ký Với Google
                        </a>

                        <!-- Links -->
                        <div class="text-center mt-4">
                            <p class="mb-0" style="color: #64748B;">
                                Đã có tài khoản?
                                <a href="{{ route('login') }}">Đăng nhập ngay</a>
                            </p>
                        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>