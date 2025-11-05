@extends('admin.layouts.admin')

@section('title', 'Thêm FAQ')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">Thêm Câu Hỏi Thường Gặp</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 650px; margin: 0 auto;">
        <div class="card-body p-4">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Câu hỏi <span class="text-danger">*</span></label>
                    <input type="text" name="question" class="form-control @error('question') is-invalid @enderror"
                           value="{{ old('question') }}" style="border-color: #F0D9DE;" required>
                    @error('question') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Câu trả lời <span class="text-danger">*</span></label>
                    <textarea name="answer" rows="6" class="form-control @error('answer') is-invalid @enderror"
                              style="border-color: #F0D9DE;" required>{{ old('answer') }}</textarea>
                    @error('answer') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- 5 DANH MỤC CỐ ĐỊNH -->
                <div class="mb-3">
                    <label class="form-label fw-500" style="color: #1E293B;">Danh mục <span class="text-danger">*</span></label>
                    <select name="category" id="category" class="form-select select2-category" style="width: 100%;" required>
                        <option value="">-- Chọn danh mục --</option>
                        @php
                            $cats = [
                                'order'     => ['name' => 'Đặt hàng',   'icon' => 'fas fa-shopping-bag'],
                                'payment'   => ['name' => 'Thanh toán', 'icon' => 'fas fa-credit-card'],
                                'shipping'  => ['name' => 'Giao hàng',  'icon' => 'fas fa-truck'],
                                'warranty'  => ['name' => 'Bảo hành',   'icon' => 'fas fa-shield-alt'],
                                'return'    => ['name' => 'Đổi trả',    'icon' => 'fas fa-exchange-alt'],
                            ];
                        @endphp
                        @foreach($cats as $value => $cat)
                            <option value="{{ $value }}" data-icon="{{ $cat['icon'] }}"
                                    {{ old('category') == $value ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                           {{ old('is_active', true) ? 'checked' : '' }} style="accent-color: #FF3B3F;">
                    <label class="form-check-label" style="color: #1E293B;">Kích hoạt ngay</label>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-500" style="color: #1E293B;">Thứ tự sắp xếp</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0"
                           style="border-color: #F0D9DE;">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1"
                            style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem;">
                        <i class="fas fa-save"></i> Lưu FAQ
                    </button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn"
                       style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem;">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--single { height: 38px !important; border: 1px solid #F0D9DE !important; border-radius: 0.375rem; }
.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; padding-left: 12px; color: #1E293B; }
.select2-results__option i { width: 20px; text-align: center; margin-right: 8px; color: #FF3B3F; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const format = state => !state.id ? state.text : $(`<span><i class="${$(state.element).data('icon')}"></i> ${state.text}</span>`);
    $('.select2-category').select2({ templateResult: format, templateSelection: format, escapeMarkup: m => m, width: '100%' });
    @if(old('category')) $('#category').val('{{ old('category') }}').trigger('change'); @endif
});
</script>
@endpush
@endsection
