@extends('admin.layouts.admin')

@section('title', 'Duyệt Đánh Giá')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Duyệt Đánh Giá #{{ $review->id }}</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 650px; margin: 0 auto;">
        <div class="card-body p-4">

            <!-- THÔNG BÁO -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-3" style="background-color: #E6F7E9; border: 1px solid #69DB7C; color: #1E293B; border-radius: 8px; padding: 12px 16px;" role="alert">
                    <i class="fas fa-check-circle me-2" style="color: #69DB7C;"></i>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif

            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" style="display: inline-block;">
                @csrf @method('PUT')

                <!-- Thông tin chỉ xem -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Người dùng</label>
                        <p class="fw-500" style="color: #1E293B;">{{ $review->user->full_name ?? 'Khách vãng lai' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Sản phẩm</label>
                        <p class="fw-500" style="color: #1E293B;">{{ $review->product->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small">Nội dung</label>
                        <p class="border rounded p-3 bg-light" style="color: #1E293B; line-height: 1.6;">
                            {!! nl2br(e($review->comment)) !!}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Điểm</label>
                        <p class="fw-500" style="color: #1E293B;">
                            @for($i = 0; $i < $review->rating; $i++) ⭐ @endfor
                            ({{ $review->rating }} sao)
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small">Thời gian</label>
                        <p class="fw-500" style="color: #475569;">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <hr style="border-color: #F0D9DE;">

                <!-- Chỉnh sửa trạng thái -->
                <div class="mb-4">
                    <label class="form-label fw-500" style="color: #1E293B;">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" style="border-color: #F0D9DE;" required>
                        <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                    @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-check"></i> Cập nhật trạng thái
                    </button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>

            <!-- NÚT XÓA (ngay trong form edit) -->
            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('⚠️ Xóa vĩnh viễn đánh giá này? Không thể khôi phục!')">
                @csrf @method('DELETE')
                <button type="submit" class="btn mt-3" style="background-color: #FF99AC; color: white; border: none; padding: 0.75rem 1.5rem; width: 100%;">
                    <i class="fas fa-trash"></i> Xóa Đánh Giá
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
