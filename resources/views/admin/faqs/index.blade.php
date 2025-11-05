@extends('admin.layouts.admin')

@section('title', 'Quản Lý FAQ')

@section('content')
<div class="container-fluid" style="background-color: #F8FAFC; min-height: 100vh; padding: 20px 0;">
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">❓ Quản Lý Câu Hỏi Thường Gặp</h1>
    </div>

    <a href="{{ route('admin.faqs.create') }}" class="btn mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 0.75rem 1.5rem;">
        <i class="fas fa-plus"></i> Thêm FAQ
    </a>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 8px; overflow: hidden; background: white;">
        <div class="card-body p-0">
            <div class="accordion" id="accordionFAQ">
                @php
                    $categories = [
                        'order'     => ['name' => 'Đặt hàng',   'icon' => 'fas fa-shopping-bag'],
                        'payment'   => ['name' => 'Thanh toán', 'icon' => 'fas fa-credit-card'],
                        'shipping'  => ['name' => 'Giao hàng',  'icon' => 'fas fa-truck'],
                        'warranty'  => ['name' => 'Bảo hành',   'icon' => 'fas fa-shield-alt'],
                        'return'    => ['name' => 'Đổi trả',    'icon' => 'fas fa-exchange-alt'],
                    ];
                    $grouped = $faqs->groupBy('category');
                @endphp

                @foreach($categories as $key => $cat)
                    @php $items = $grouped->get($key, collect()) @endphp
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button collapsed fw-medium" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}"
                                    style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; font-weight: 600;">
                                <i class="{{ $cat['icon'] }} me-2"></i>
                               {{ $cat['name'] }} <span style="margin-left: 8px; font-weight: 500;">({{ $items->count() }})</span>
                            </button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body p-0">
                                @if($items->isEmpty())
                                    <div class="p-3 text-center text-muted small">
                                        <i class="fas fa-inbox"></i> Chưa có câu hỏi nào.
                                    </div>
                                @else
                                    @foreach($items as $faq)
                                        <div style="border-bottom: 1px solid #CBD5E1; padding: 16px; background-color: #F8FAFC;">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div style="flex: 1;">
                                                    <h6 class="mb-1" style="color: #1E293B;">{{ $faq->question }}</h6>
                                                    <p class="text-muted small mb-0" style="max-height: 40px; overflow: hidden;">
                                                        {{ Str::limit(strip_tags($faq->answer), 100) }}
                                                    </p>
                                                </div>
                                                <div class="d-flex gap-1 ms-3">
                                                    <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-sm"
                                                       style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                                          style="display: inline-block;" onsubmit="return confirm('Xóa?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm"
                                                                style="background-color: #00B4D8; color: white; border: none;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
