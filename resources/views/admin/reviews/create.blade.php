@extends('admin.layouts.admin')

@section('title', 'Thêm Đánh Giá')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm Đánh Giá</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.store') }}" method="POST">
                @csrf

                <!-- Nội dung -->
                <div class="mb-3">
                    <label for="comment" class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Người dùng (datalist) -->
                <div class="mb-3">
                    <label for="user_name" class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                    <input list="users_list" name="user_name" id="user_name"
                           class="form-control @error('user_name') is-invalid @enderror"
                           value="{{ old('user_name') }}" required>
                    <datalist id="users_list">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}">
                        @endforeach
                    </datalist>
                    <!-- Input ẩn để lưu user_id -->
                    <input type="hidden" name="user_id" id="user_id_hidden">
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sản phẩm -->
                <div class="mb-3">
                    <label for="product_id" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hiển thị -->
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Hiển thị</label>
                    </div>
                </div>

                <!-- Điểm đánh giá -->
                <div class="mb-3">
                    <label for="rating" class="form-label">Điểm đánh giá <span class="text-danger">*</span></label>
                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm Đánh Giá
                </button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>

<!-- JS tự động điền user_id -->
<script>
const input = document.getElementById('user_name');
const hidden = document.getElementById('user_id_hidden');

input.addEventListener('input', function() {
    const option = Array.from(document.getElementById('users_list').options)
                        .find(o => o.value === input.value);
    hidden.value = option ? option.dataset.id : '';
});
</script>
@endsection
