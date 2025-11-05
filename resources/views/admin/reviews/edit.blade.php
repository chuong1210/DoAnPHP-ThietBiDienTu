@extends('admin.layouts.admin')

@section('title', 'Chỉnh Sửa Đánh Giá')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Chỉnh Sửa Đánh Giá</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nội dung -->
                <div class="mb-3">
                    <label for="comment" class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" rows="5">{{ old('comment', $review->comment) }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Người dùng (datalist) -->
                <div class="mb-3">
                    <label for="user_name" class="form-label">Tên người dùng <span class="text-danger">*</span></label>
                    <input list="users_list" name="user_name" id="user_name"
                           class="form-control @error('user_name') is-invalid @enderror"
                           value="{{ old('user_name', $review->user_name) }}" required>
                    <datalist id="users_list">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}">
                        @endforeach
                    </datalist>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sản phẩm -->
                <div class="mb-3">
                    <label for="product_id" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $review->product_id) == $product->id ? 'selected' : '' }}>
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
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $review->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Hiển thị</label>
                    </div>
                </div>

                <!-- Điểm đánh giá -->
                <div class="mb-3">
                    <label for="rating" class="form-label">Điểm đánh giá <span class="text-danger">*</span></label>
                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
