@extends('admin.layouts.admin')

@section('title', 'Xem Đánh Giá #{{ $review->id }}')

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px;">
        <h1 class="h3 mb-0">Xem Đánh Giá #{{ $review->id }}</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 700px; margin: auto;">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Người dùng</label>
                    <p class="mb-0">{{ $review->user_name }} <small class="text-muted">(ID: {{ $review->user_id }})</small></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Sản phẩm</label>
                    <p class="mb-0">{{ $review->product->name ?? 'Sản phẩm đã xóa' }}</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Đánh giá</label>
                    <div style="display: flex; gap: 4px; font-size: 20px;">
                        @for($i = 0; $i < $review->rating; $i++)
                            <span style="color: #FFB800;">★</span>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <span style="color: #CBD5E1;">★</span>
                        @endfor
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Trạng thái</label>
                   <span class="badge" style="
                        background-color:
                            {{ $review->status === 'pending' ? '#F59E0B' :
                            ($review->status === 'approved' ? '#10B981' : '#EF4444') }};
                        color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.8rem;">
                        {{ $review->status === 'pending' ? 'Chưa duyệt' :
                        ($review->status === 'approved' ? 'Đã duyệt' : 'Từ chối') }}
                    </span>
                </div>
                <div class="col-12">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Nội dung đánh giá</label>
                    <p class="border p-3 rounded" style="background: #F8FAFC; min-height: 80px;">{{ $review->comment ?: '— Không có nội dung —' }}</p>
                </div>
                <div class="col-12">
                    <label class="form-label" style="color: #1E293B; font-weight: 600;">Thời gian</label>
                    <p class="mb-0 text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

           <!-- Thay đổi trạng thái (Admin có quyền) -->
        <div class="mt-4">
            <label class="form-label" style="color: #1E293B; font-weight: 600;">Cập nhật trạng thái</label>
            <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" class="d-flex gap-2 align-items-center">
                @csrf @method('PATCH')
                <select name="status" class="form-select form-select-sm" style="width: auto; border-color: #CBD5E1; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="pending" {{ $review->status === 'pending' ? 'selected' : '' }} style="color: #F59E0B;">Chưa duyệt</option>
                    <option value="approved" {{ $review->status === 'approved' ? 'selected' : '' }} style="color: #10B981;">Đã duyệt</option>
                    <option value="rejected" {{ $review->status === 'rejected' ? 'selected' : '' }} style="color: #EF4444;">Từ chối</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" style="padding: 6px 12px; border-radius: 6px;">
                    Cập nhật
                </button>
            </form>
        </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.reviews.index') }}" class="btn flex-grow-1" style="background: #E0F2FE; color: #0066FF; border: 1px solid #0066FF;">
                    Quay lại danh sách
                </a>
                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger">Xóa đánh giá</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
