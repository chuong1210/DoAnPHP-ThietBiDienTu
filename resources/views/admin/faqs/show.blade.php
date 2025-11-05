@extends('admin.layouts.admin')

@section('title', 'Chi tiết FAQ')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">🔍 Chi tiết câu hỏi thường gặp</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            {{ $faq->question }}
        </div>
        <div class="card-body">
            <p>{!! nl2br(e($faq->answer)) !!}</p>
            <p><strong>Danh mục:</strong> {{ $faq->category ?? 'Khác' }}</p>
            <p><strong>Kích hoạt:</strong> {{ $faq->is_active ? 'Có' : 'Không' }}</p>
            <p><strong>Thứ tự sắp xếp:</strong> {{ $faq->sort_order }}</p>
        </div>
        <div class="card-footer">
            <a
