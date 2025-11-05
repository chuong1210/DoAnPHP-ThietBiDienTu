@extends('admin.layouts.admin')

@section('title', "Câu hỏi về $category")

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
            ← Quay lại tất cả câu hỏi
        </a>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm FAQ
        </a>
    </div>

    <h2 class="text-primary mb-4">💡 Câu hỏi về: {{ $category }}</h2>

    @if($faqs->isEmpty())
        <div class="alert alert-info">Hiện chưa có câu hỏi nào trong danh mục này.</div>
    @else
        <div class="accordion" id="accordionCategory">
            @foreach($faqs as $faq)
                <div class="accordion-item mb-2 border rounded">
                    <h2 class="accordion-header d-flex justify-content-between align-items-center" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed fw-semibold flex-grow-1" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}">
                            {{ $faq->question }}
                        </button>
                        <div class="ms-2">
                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionCategory">
                        <div class="accordion-body">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
