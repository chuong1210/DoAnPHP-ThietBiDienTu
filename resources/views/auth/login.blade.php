?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4">Đăng Nhập</h3>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('auth.login.post') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="example@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Đăng Nhập
                            </button>

                            <!-- Links -->
                            <div class="text-center">
                                <p class="mb-0">
                                    Chưa có tài khoản?
                                    <a href="{{ route('auth.register') }}">Đăng ký ngay</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Demo accounts -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6>Tài khoản Demo:</h6>
                        <small class="text-muted">
                            <strong>Admin:</strong> admin@shop.com / Admin1234<br>
                            <strong>User:</strong> user1@gmail.com / User1234
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
