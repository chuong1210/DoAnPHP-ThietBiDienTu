@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Banner')

@section('content')
    <div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
        <!-- Updated header styling -->
        <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
            <h1 class="h3 mb-0">✏️ Chỉnh Sửa Banner</h1>
        </div>

        <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 600px; margin: 0 auto;">
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label" style="color: #1E293B; font-weight: 500;">Tiêu đề <span style="color: #FF3B3F;">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" style="border-color: #F0D9DE;">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label" style="color: #1E293B; font-weight: 500;">Hình ảnh</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" style="border-color: #F0D9DE;">
                        @if ($banner->image && file_exists(public_path('images/' . $banner->image)))
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $banner->id }}" class="mt-2 d-inline-block">
                                <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 150px; border-radius: 4px;">
                            </a>
                            <div class="modal fade" id="imageModal{{ $banner->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $banner->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="border: 1px solid #F0D9DE; border-radius: 8px;">
                                        <div class="modal-header" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                                            <h5 class="modal-title" id="imageModalLabel{{ $banner->id }}">{{ $banner->title }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center" style="background-color: #FFF5F7;">
                                            <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 100%; height: auto; border-radius: 4px;">
                                        </div>
                                        <div class="modal-footer" style="background-color: white; border-top: 1px solid #F0D9DE;">
                                            <button type="button" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none;" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="text-danger mt-2 d-block">Ảnh hiện tại không tồn tại</span>
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label" style="color: #1E293B; font-weight: 500;">Liên kết</label>
                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $banner->link) }}" style="border-color: #F0D9DE;">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label" style="color: #1E293B; font-weight: 500;">Thứ tự</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $banner->sort_order) }}" min="0" style="border-color: #F0D9DE;">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} style="border-color: #F0D9DE; accent-color: #FF3B3F;">
                            <label for="is_active" class="form-check-label" style="color: #1E293B;">Hiển thị</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
