@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h1>Chi tiết câu hỏi</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $contact->id }}</td>
        </tr>
        <tr>
            <th>Tên</th>
            <td>{{ $contact->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $contact->email }}</td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td>{{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}</td>
        </tr>
        <tr>
            <th>Nội dung câu hỏi</th>
            <td>{{ $contact->message }}</td>
        </tr>
    </table>

    @if($contact->status == 'new')
    <h3>Trả lời khách hàng</h3>
    <form action="{{ route('admin.contact.send', $contact->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject" class="form-label">Tiêu đề email</label>
            <input type="text" class="form-control" name="subject" id="subject" value="Phản hồi từ Shop" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Nội dung phản hồi</label>
            <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Gửi email</button>
    </form>
    @endif

    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection
