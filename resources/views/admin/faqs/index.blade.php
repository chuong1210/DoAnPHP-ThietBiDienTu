@extends('admin.layouts.admin')

@section('title', 'Danh sách FAQ')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">📝 Danh sách câu hỏi thường gặp</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm FAQ
        </a>
    </div>

    @foreach($faqs->groupBy('category') as $category => $faqGroup)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                {{ $category ?? 'Khác' }}
                <a href="{{ route('admin.faqs.category', $category) }}" class="btn btn-light btn-sm">
                    Xem chi tiết
                </a>
            </div>

            <div class="card-body">
                <ul class="list-group">
                    @foreach($faqGroup as $faq)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $faq->question }}
                            <div>
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ route('admin.faqs.show', $faq) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection
