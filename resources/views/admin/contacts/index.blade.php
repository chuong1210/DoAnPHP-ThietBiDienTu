@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h1>Danh sách câu hỏi từ khách hàng</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}</td>
                <td>
                    <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-info btn-sm">Xem / Trả lời</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
