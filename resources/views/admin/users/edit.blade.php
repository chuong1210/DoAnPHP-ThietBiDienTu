@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
    <div class="container-fluid py-4">
        <h3 class="fw-bold mb-3">Chỉnh Sửa Người Dùng</h3>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Họ Tên</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Số Điện Thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quyền</label>
                        <select name="role" class="form-select">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Căn 2 nút trên cùng một hàng -->
                <div class="d-flex justify-content-start gap-2 mt-3">
                    <button class="btn btn-success"><i class="fas fa-save"></i> Lưu Thay Đổi</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>
@endsection
