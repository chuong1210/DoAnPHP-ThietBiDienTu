@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Updated header with red gradient -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">📧 Danh sách câu hỏi từ khách hàng</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="border-color: #F0D9DE;">
                    <thead style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white;">
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
                        <tr style="border-bottom: 1px solid #F0D9DE;">
                            <td style="color: #1E293B;">{{ $contact->id }}</td>
                            <td style="color: #1E293B; font-weight: 500;">{{ $contact->name }}</td>
                            <td style="color: #FF3B3F;">{{ $contact->email }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $contact->status == 'new' ? '#FF99AC' : '#FFD4DC' }}; color: #1E293B;">
                                    {{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none; text-decoration: none;">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
