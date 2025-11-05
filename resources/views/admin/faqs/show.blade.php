@extends('admin.layouts.admin')

@section('title', 'Chi tiết FAQ')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">📄 Chi Tiết Câu Hỏi Thường Gặp</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 700px; margin: 0 auto;">
        <!-- Question Header -->
        <div class="card-header" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border-radius: 8px 8px 0 0;">
            <h5 class="mb-0 fw-bold">{{ $faq->question }}</h5>
        </div>

        <!-- Body -->
        <div class="card-body" style="background-color: #FFF5F7;">
            <div class="mb-4">
                <h6 class="fw-600" style="color: #1E293B;">Câu trả lời:</h6>
                <div class="p-3 rounded" style="background-color: #ffffff; border: 1px solid #F0D9DE; color: #1E293B; line-height: 1.7;">
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>

            <hr style="border-color: #F0D9DE;">

            <div class="row g-3">
                <div class="col-md-6">
                    <strong style="color: #1E293B;">Danh mục:</strong>
                    <span class="badge ms-2" style="background-color: #FF99AC; color: white; font-size: 0.9em;">
                        {{ $faq->category ?? 'Không xác định' }}
                    </span>
                </div>
                <div class="col-md-6">
                    <strong style="color: #1E293B;">Thứ tự:</strong>
                    <span style="color: #475569;">{{ $faq->sort_order }}</span>
                </div>
                <div class="col-md-6">
                    <strong style="color: #1E293B;">Trạng thái:</strong>
                    @if($faq->is_active)
                        <span class="badge" style="background-color: #FF3B3F; color: white;">Đang hiển thị</span>
                    @else
                        <span class="badge" style="background-color: #F0D9DE; color: #1E293B;">Ẩn</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="card-footer d-flex justify-content-between" style="background-color: #FFF5F7; border-top: 1px solid #F0D9DE;">
            <div>
                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                    <i class="fas fa-edit"></i> Chỉnh sửa
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm" style="background-color: #F0D9DE; color: #1E293B; border: none;">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Xóa vĩnh viễn FAQ này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm" style="background-color: #FF6B81; color: white; border: none;">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
