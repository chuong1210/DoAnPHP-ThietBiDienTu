@extends('admin.layouts.admin')

@section('title', 'Quản Lý Sản Phẩm')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="h3 mb-0">Quản Lý Sản Phẩm</h1>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm Sản Phẩm
                </a>
            </div>
        </div>

        <!-- Thông báo -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Bộ lọc và tìm kiếm -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.products.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên..."
                                value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-control">
                                <option value="">-- Tất cả danh mục --</option>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_featured" value="1" class="form-check-input"
                                    id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Sản phẩm nổi bật
                                </label>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Nút hành động -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-save"></i> Lưu Sản Phẩm
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </div>
        </div>
    </div>
    </form>
    </div>

    <script>
        // Preview ảnh trước khi upload
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 300px;">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection