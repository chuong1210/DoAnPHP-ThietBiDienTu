@extends('admin.layouts.admin')

@section('title', 'Thêm Đánh Giá')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Thêm Đánh Giá</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 650px; margin: 0 auto;">
        <div class="card-body p-4">
            <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nội dung -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Nội dung</label>
                    <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" style="border-color: #F0D9DE;">{{ old('comment') }}</textarea>
                    @error('comment') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Người dùng -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Người dùng <span class="text-danger">*</span></label>
                    <input list="users_list" name="user_name" id="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name') }}" style="border-color: #F0D9DE;" placeholder="Nhập tên người dùng..." required>
                    <datalist id="users_list">
                        @foreach($users as $user)
                            <option value="{{ $user->name }}" data-id="{{ $user->id }}">
                        @endforeach
                    </datalist>
                    <input type="hidden" name="user_id" id="user_id_hidden" required>
                    @error('user_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Sản phẩm -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Sản phẩm <span class="text-danger">*</span></label>
                    <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" style="border-color: #F0D9DE;" required>
                        <option value="">-- Chọn sản phẩm --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Điểm -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Điểm đánh giá <span class="text-danger">*</span></label>
                    <select name="rating" class="form-select @error('rating') is-invalid @enderror" style="border-color: #F0D9DE;" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} sao</option>
                        @endfor
                    </select>
                    @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Ảnh -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Ảnh minh họa</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" style="border-color: #F0D9DE;">
                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-save"></i> Thêm Đánh Giá
                    </button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('user_name');
        const hidden = document.getElementById('user_id_hidden');

        function updateUserId() {
            const option = Array.from(document.querySelectorAll('#users_list option'))
                .find(opt => opt.value === input.value.trim());
            hidden.value = option ? option.dataset.id : '';
        }

        input.addEventListener('input', updateUserId);
        input.addEventListener('change', updateUserId);

        // Nếu có old value
        @if(old('user_name'))
            input.value = '{{ old('user_name') }}';
            updateUserId();
        @endif
    });
</script>
@endsection
