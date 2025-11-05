{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Tech Shop</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .brand-logo p {
            color: #64748B;
            font-size: 0.9rem;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 102, 255, 0.1);
            border: 1px solid var(--neutral);
            padding: 2.5rem;
            animation: fadeInUp 0.6s ease;
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

        .demo-card {
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            border-radius: 16px;
            padding: 1.25rem;
            margin-top: 1.5rem;
            border: 2px solid #FCD34D;
            animation: fadeInUp 0.8s ease;
        }

        .demo-card h6 {
            color: #92400E;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-card small {
            color: #78350F;
            line-height: 1.6;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
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
            /* Đổi tên từ i thành .form-icon để không bị xung đột */
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            pointer-events: none;
            /* Icon không thể click */
        }

        .input-icon .form-control {
            padding-left: 2.75rem;
        }


        /* === CSS CHO NÚT TOGGLE MẬT KHẨU === */
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
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <!-- Brand Logo -->
            <div class="brand-logo">
                <i class="fas fa-microchip"></i>
                <h2>Tech Shop</h2>
                <p>Công nghệ hiện đại, trải nghiệm tuyệt vời</p>
            </div>

            <!-- Login Card -->
            <div class="login-card">
                <h4 class="text-center mb-4" style="color: var(--text); font-weight: 700;">Đăng Nhập</h4>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if(session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-envelope me-1"></i> Email</label>
                        <div class="input-icon">
                            <i class="fas fa-at form-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="your.email@example.com" required>
                        </div>
                        @error('email')
                            {{-- Chỉ hiển thị lỗi của password để tránh lặp lại --}}
                            @if($errors->has('password'))
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @endif
                        @enderror
                    </div>


                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-lock me-1"></i> Mật khẩu</label>
                        <div class="input-icon">
                            <i class="fas fa-key form-icon"></i>
                            <input type="password" name="password" id="password-input" {{-- Thêm id --}}
                                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                required>

                            {{-- THÊM ICON MẮT VÀO ĐÂY --}}
                            <i class="fas fa-eye password-toggle-icon" id="password-toggle"></i>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember" style="font-weight: 500;">
                                Ghi nhớ
                            </label>
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        </div>
                    </div>


                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Đăng Nhập
                    </button>

                    <!-- Divider -->
                    <div class="divider">
                        <span>hoặc tiếp tục với</span>
                    </div>

                    <!-- Google Login -->
                    <a href="{{ route('auth.google') }}" class="btn btn-google w-100">
                        <i class="fab fa-google me-2"></i> Đăng Nhập Với Google
                    </a>

                    <!-- Links -->
                    <div class="text-center mt-4">
                        <p class="mb-0" style="color: #64748B;">
                            Chưa có tài khoản?
                            <a href="{{ route('register') }}">Đăng ký ngay</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Demo Card -->
            <div class="demo-card">
                <h6>
                    <i class="fas fa-info-circle"></i> Tài khoản Demo
                </h6>
                <small>
                    <strong>👨‍💼 Admin:</strong> admin@shop.com / Admin1234<br>
                    <strong>👤 User:</strong> user1@gmail.com / User1234
                </small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password-input');
            const passwordToggle = document.getElementById('password-toggle');

            if (passwordInput && passwordToggle) {
                passwordToggle.addEventListener('click', function () {
                    // Lấy ra type hiện tại của input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Thay đổi icon mắt
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>

</html>