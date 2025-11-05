@extends('admin.layouts.admin')

@section('title', 'Sửa FAQ')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">✏️ Sửa câu hỏi thường gặp</h1>

    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="question" class="form-label">Câu hỏi</label>
            <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
        </div>

        <div class="mb-3">
            <label for="answer" class="form-label">Câu trả lời</label>
            <textarea name="answer" id="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $faq->category) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $faq->is_active ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Kích hoạt</label>
        </div>

        <div class="mb-3">
            <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order) }}">
        </div>

        <button type="submit" class="btn btn-success">Cập nhật FAQ</button>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
