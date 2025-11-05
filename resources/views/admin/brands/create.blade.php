@extends('admin.layouts.admin')

@section('title', 'Thêm Mới Thương Hiệu')
@section('page-title', 'Thêm Mới Thương Hiệu')

@section('styles')
    <style>
        .form-control,
        .form-check-input {
            border-color: var(--border-color);
            background-color: var(--bg-main);
        }

        .form-control:focus,
        .form-check-input:checked {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 59, 63, 0.1);
            background-color: var(--bg-white);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
        }

        .btn-save {
            background: var(--primary-gradient);
            color: white;
            border: none;
        }

        .btn-cancel {
            background-color: var(--bg-white);
            border: 2px solid var(--border-color);
        }

        /* Image Preview */
        #image-preview-container {
            width: 200px;
            height: 200px;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-main);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        #image-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        #image-preview-container .placeholder {
            color: var(--text-muted);
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông Tin Thương Hiệu</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Tên Thương Hiệu -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Tên Thương Hiệu <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Logo</label>
                            <div id="image-preview-container" onclick="document.getElementById('logo').click()">
                                <img id="image-preview" src="#" alt="Preview" style="display: none;">
                                <div id="image-placeholder" class="placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                                    <p>Nhấn để tải lên</p>
                                </div>
                            </div>
                            <input type="file" id="logo" name="logo" class="d-none @error('logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="form-text text-muted">Đề xuất: PNG, JPG, SVG,... dưới 2MB</small>
                            @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng Thái -->
                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active"
                                value="1" checked>
                            <label class="form-check-label fw-bold" for="is_active">Kích hoạt</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.brands.index') }}" class="btn btn-cancel">Hủy</a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i> Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('logo').addEventListener('change', function (event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-placeholder');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
        });
    </script>
@endsection