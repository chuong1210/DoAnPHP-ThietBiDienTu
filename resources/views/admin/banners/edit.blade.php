@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Banner')

@section('content')
    <div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
        <!-- Tech Blue header styling -->
        <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.2);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
                <h1 class="h3 mb-0">Chỉnh Sửa Banner</h1>
            </div>
        </div>

        <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 700px; margin: 0 auto; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
            <div class="card-body" style="padding: 32px;">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Tiêu đề <span style="color: #0066FF;">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Hình ảnh</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;">
                        @if ($banner->image && file_exists(public_path('images/' . $banner->image)))
                            <div class="mt-3">
                                <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 150px; border-radius: 8px; border: 2px solid #E0F2FE;">
                            </div>
                        @else
                            <span class="text-muted mt-2 d-block">Ảnh hiện tại không tồn tại</span>
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Liên kết</label>
                        <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $banner->link) }}" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 8px;">Thứ tự</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order) }}" style="border-color: #CBD5E1; border-radius: 8px; padding: 10px 12px;" min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} style="border-color: #CBD5E1; accent-color: #0066FF;">
                            <label for="is_active" class="form-check-label" style="color: #1E293B;">Hiển thị</label>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 500;">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn" style="background-color: #E0F2FE; color: #0066FF; border: none; padding: 12px 20px; border-radius: 8px; text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
