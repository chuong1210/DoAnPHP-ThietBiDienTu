@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Sản Phẩm')
@section('page-title', 'Chỉnh Sửa Sản Phẩm')

@section('styles')
    {{-- Dùng chung style với trang create --}}
    <style>
        .form-control,
        .form-select,
        .form-check-input {
            border-color: var(--border-color);
            background-color: var(--bg-main);
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:checked {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(255, 59, 63, 0.1);
            background-color: var(--bg-white);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
        }

        .image-uploader {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            background-color: var(--bg-main);
            transition: all 0.2s ease;
        }

        .image-uploader:hover {
            border-color: var(--primary-color);
            background-color: var(--bg-white);
        }

        .image-uploader .icon {
            font-size: 3rem;
            color: var(--secondary-color);
        }

        .image-uploader p {
            color: var(--text-muted);
            margin: 0;
        }

        #image-preview,
        #images-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .remove-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            border: 2px solid white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Cột trái -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Thông Tin Chi Tiết</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tên Sản Phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô Tả Sản Phẩm</label>
                            <textarea name="description" class="form-control"
                                rows="8">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Giá Gốc (VNĐ) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $product->price) }}" step="1000">
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Giá Khuyến Mãi</label>
                                <input type="number" name="sale_price"
                                    class="form-control @error('sale_price') is-invalid @enderror"
                                    value="{{ old('sale_price', $product->sale_price) }}" step="1000">
                                @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Số Lượng Kho <span class="text-danger">*</span></label>
                                <input type="number" name="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity', $product->quantity) }}">
                                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Hình Ảnh</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh Đại Diện</label>
                            <div class="image-uploader" onclick="document.getElementById('main-image-input').click()">
                                <i class="fas fa-cloud-upload-alt icon"></i>
                                <p>Nhấn để thay đổi ảnh đại diện</p>
                            </div>
                            <input type="file" id="main-image-input" name="image"
                                class="d-none @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <div id="image-preview">
                                @if($product->image)
                                    <div class="preview-item">
                                        <img src="{{ asset($product->image) }}" alt="Current Image">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="form-label fw-bold">Ảnh Bổ Sung (Chức năng này cần được phát triển thêm ở
                                Controller)</label>
                            <div class="image-uploader" onclick="document.getElementById('extra-images-input').click()">
                                <i class="fas fa-images icon"></i>
                                <p>Nhấn để tải lên ảnh mới</p>
                            </div>
                            <input type="file" id="extra-images-input" name="images[]" class="d-none" accept="image/*"
                                multiple>
                            <div id="images-preview">
                                {{-- Kiểm tra xem $product->images có phải là mảng và không rỗng --}}
                                @if(is_array($product->images) && !empty($product->images))
                                    {{-- Lặp trực tiếp qua mảng $product->images --}}
                                    @foreach($product->images as $img)
                                        <div class="preview-item"><img src="{{ asset($img) }}" alt="Extra Image"></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cột phải -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Xuất Bản</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Trạng Thái</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                    Công khai (Đang bán)</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Bản nháp (Ngừng bán)</option>
                            </select>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_featured">Đặt làm sản phẩm nổi bật</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i> Cập
                                Nhật</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Phân Loại</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Danh Mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="form-label fw-bold">Thương Hiệu <span class="text-danger">*</span></label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">-- Chọn thương hiệu --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        // Preview ảnh đại diện khi thay đổi
        document.getElementById('main-image-input').addEventListener('change', function (event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ''; // Xóa ảnh cũ đang hiển thị
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    item.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    previewContainer.appendChild(item);
                }
                reader.readAsDataURL(file);
            }
        });

        // Preview nhiều ảnh khi thay đổi
        document.getElementById('extra-images-input').addEventListener('change', function (event) {
            const previewContainer = document.getElementById('images-preview');
            previewContainer.innerHTML = ''; // Xóa các ảnh cũ đang hiển thị
            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const item = document.createElement('div');
                        item.className = 'preview-item';
                        item.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        previewContainer.appendChild(item);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endsection