@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Câu hỏi thường gặp (FAQ)</h2>

    @foreach($groups as $key => [$label, $icon])
     <tr>
        <td><i class="{{ $faq->category_icon }}"></i> {{ $faq->category_label }}</td>
        <td>{{ $faq->question }}</td>
        <td>{{ $faq->answer }}</td>
    </tr>
        @if(isset($faqs[$key]) && count($faqs[$key]) > 0)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="{{ $icon }} me-2"></i>
                    <strong>{{ $label }}</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($faqs[$key] as $faq)
                            <li class="list-group-item">
                                <strong class="text-dark">{{ $faq->question }}</strong>
                                <p class="mb-0 text-muted">{{ $faq->answer }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection
