{{-- resources/views/auth/verify.blade.php --}}
@extends('client.layouts.client') {{-- Hoặc một layout chung nào đó --}}

@section('title', 'Xác thực Email')
@php
    $hideSidebar = true;
@endphp
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Xác thực địa chỉ Email của bạn</h4>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <p>Trước khi tiếp tục, vui lòng kiểm tra email của bạn để tìm liên kết xác minh.</p>
                        <p>Nếu bạn không nhận được email, hãy nhấn vào nút bên dưới để gửi lại.</p>

                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Gửi lại email xác thực
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection