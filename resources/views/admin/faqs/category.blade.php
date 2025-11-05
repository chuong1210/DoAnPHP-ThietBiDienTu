@extends('admin.layouts.admin')

@section('title', "Câu hỏi về $categoryName")

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.faqs.index') }}" class="btn"
           style="background-color: #F0D9DE; color: #1E293B; border: none; padding: 0.75rem 1.5rem;">
            ← Quay lại
        </a>
        <a href="{{ route('admin.faqs.create') }}" class="btn"
           style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; padding: 0.75rem 1.5rem;">
            <i class="fas fa-plus"></i> Thêm FAQ
        </a>
    </div>

    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h2 class="h4 mb-0">Câu hỏi về: <strong>{{ $categoryName }}</strong></h2>
    </div>

    @if($faqs->isEmpty())
        <div class="alert text-center" style="background-color: #FFE8ED; border: 1px solid #F0D9DE; color: #1E293B; border-radius: 8px;">
            <i class="fas fa-info-circle"></i> Chưa có câu hỏi nào trong danh mục này.
        </div>
    @else
        <div class="accordion" id="accordionCategory">
            @foreach($faqs as $faq)
                <div class="accordion-item mb-3" style="border: 1px solid #F0D9DE; border-radius: 8px; overflow: hidden;">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed fw-medium" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                style="color: #1E293B; background-color: #ffffff;">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionCategory">
                        <div class="accordion-body" style="background-color: #FFF5F7; color: #1E293B;">
                            {!! nl2br(e($faq->answer)) !!}
                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm"
                                   style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa FAQ này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                            style="background-color: #FF99AC; color: white; border: none;">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
