@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); padding: 30px; border-radius: 12px; color: white;">
                    <h2 class="fw-bold mb-1" style="font-size: 28px;">✏️ Chỉnh Sửa Người Dùng</h2>
                    <p style="margin: 0; opacity: 0.95;">Cập nhật thông tin tài khoản người dùng</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 4px solid #0066FF;">
                <div class="card-header" style="background-color: #F8FAFC; border-bottom: 1px solid #CBD5E1; padding: 20px;">
                    <h5 class="mb-0" style="color: #1E293B; font-weight: 600;">
                        <i class="fas fa-info-circle" style="color: #0066FF; margin-right: 8px;"></i>Thông Tin Người Dùng
                    </h5>
                </div>

                <div class="card-body" style="padding: 30px;">
                    <!-- Email Field (Disabled) -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px;">📧 Email</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled
                            style="background-color: #F8FAFC; border: 1px solid #CBD5E1; color: #1E293B; border-radius: 8px; padding: 12px;">
                        <small style="color: #64748B;">Email không thể thay đổi</small>
                    </div>

                    <!-- Full Name Field -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px;">👤 Họ Tên</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                            class="form-control" style="border: 1px solid #CBD5E1; border-radius: 8px; padding: 12px; background-color: white;">
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-4">
                        <label class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px;">📱 Số Điện Thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="form-control" style="border: 1px solid #CBD5E1; border-radius: 8px; padding: 12px; background-color: white;">
                    </div>

                    <!-- Role and Status Row -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px;">👑 Quyền</label>
                            <select name="role" class="form-select" style="border: 1px solid #CBD5E1; border-radius: 8px; padding: 12px; background-color: white; color: #1E293B;">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>👤 User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>👑 Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px;">🔄 Trạng Thái</label>
                            <select name="status" class="form-select" style="border: 1px solid #CBD5E1; border-radius: 8px; padding: 12px; background-color: white; color: #1E293B;">
                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>✅ Active</option>
                                <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>⏸️ Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer" style="background-color: #F8FAFC; border-top: 1px solid #CBD5E1; padding: 20px;">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn" style="background-color: #0066FF; color: white; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; transition: all 0.2s;">
                            <i class="fas fa-save"></i> Lưu Thay Đổi
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn" style="background-color: #CBD5E1; color: #1E293B; border: none; border-radius: 8px; padding: 12px 24px; font-weight: 600; transition: all 0.2s;">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
