<div class="col-md-9 profile-content">
    <h4 class="mb-4 fw-bold">Đổi mật khẩu</h4>
    <hr class="mb-4">

    <form action="{{ route('profile.update.password') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label fw-bold">Mật khẩu hiện tại <span
                    class="text-danger">*</span></label>
            <input type="password" id="current_password" name="current_password"
                class="form-control @error('current_password') is-invalid @enderror" required
                placeholder="Nhập mật khẩu hiện tại">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required minlength="8"
                    placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label fw-bold">Xác nhận mật khẩu mới <span
                        class="text-danger">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror" required
                    placeholder="Xác nhận mật khẩu mới">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-start mt-4 gap-3">
            <button type="submit" class="btn btn-primary btn-lg px-5">ĐỔI MẬT KHẨU</button>
            <a href="{{ route('profile.index') }}" class="btn btn-secondary btn-lg px-5">QUAY LẠI</a>
        </div>
    </form>
</div>
