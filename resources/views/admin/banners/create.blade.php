@extends('admin.layouts.admin')

@section('title', 'Thêm Banner')

@section('content')
    <div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
        <!-- Updated header with red gradient -->
        <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
            <h1 class="h3 mb-0">➕ Thêm Banner</h1>
        </div>

        <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 600px; margin: 0 auto;">
            <div class="card-body">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Updated form styling -->
                    <div class="mb-3">
                        <label for="title" class="form-label" style="color: #1E293B; font-weight: 500;">Tiêu đề <span style="color: #FF3B3F;">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" style="border-color: #F0D9DE;" placeholder="Nhập tiêu đề banner">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label" style="color: #1E293B; font-weight: 500;">Hình ảnh <span style="color: #FF3B3F;">*</span></label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" style="border-color: #F0D9DE;">
                        <div id="image-preview" class="mt-2" style="display: none;">
                            <a href="#" id="preview-link" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <img id="preview-img" src="#" alt="Image Preview" style="max-width: 150px; border-radius: 4px;">
                            </a>
                        </div>
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="border: 1px solid #F0D9DE; border-radius: 8px;">
                                    <div class="modal-header" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                                        <h5 class="modal-title" id="imageModalLabel">Xem trước hình ảnh</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center" style="background-color: #FFF5F7;">
                                        <img id="modal-img" src="#" alt="Image Preview" style="max-width: 100%; height: auto; border-radius: 4px;">
                                    </div>
                                    <div class="modal-footer" style="background-color: white; border-top: 1px solid #F0D9DE;">
                                        <button type="button" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none;" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label" style="color: #1E293B; font-weight: 500;">Liên kết</label>
                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" style="border-color: #F0D9DE;" placeholder="https://example.com">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label" style="color: #1E293B; font-weight: 500;">Thứ tự</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0" style="border-color: #F0D9DE;">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }} style="border-color: #F0D9DE; accent-color: #FF3B3F;">
                            <label for="is_active" class="form-check-label" style="color: #1E293B;">Hiển thị</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                            <i class="fas fa-save"></i> Thêm Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImg = document.getElementById('preview-img');
            const previewLink = document.getElementById('preview-link');
            const modalImg = document.getElementById('modal-img');
            const previewContainer = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewLink.href = e.target.result;
                    modalImg.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>
@endsection
