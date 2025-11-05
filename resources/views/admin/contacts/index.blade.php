@extends('admin.layouts.admin')
@section('page-title', 'Hỗ trợ khách hàng')

@section('content')
    <div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
        <!-- Tech Blue gradient header with icon -->
        <div class="mb-4" style=" color: #0066FF ">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="1"/><path d="M5 12a7 7 0 1 0 14 0 7 7 0 1 0 -14 0"/>
                </svg>
                <h1 class="h3 mb-0">Danh sách liên hệ từ khách hàng</h1>
            </div>
        </div>

        <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="border-color: #CBD5E1;">
                        <thead style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white;">
                            <tr>
                                <th style="padding: 16px; font-weight: 600;">ID</th>
                                <th style="padding: 16px; font-weight: 600;">Tên</th>
                                <th style="padding: 16px; font-weight: 600;">Email</th>
                                <th style="padding: 16px; font-weight: 600;">Trạng thái</th>
                                <th style="padding: 16px; font-weight: 600;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr style="border-bottom: 1px solid #CBD5E1;">
                                <td style="color: #1E293B; padding: 16px;">{{ $contact->id }}</td>
                                <td style="color: #1E293B; font-weight: 500; padding: 16px;">{{ $contact->name }}</td>
                                <td style="color: #0066FF; padding: 16px;">{{ $contact->email }}</td>
                                <td style="padding: 16px;">
                                    <span class="badge" style="background-color: {{ $contact->status == 'new' ? '#00B4D8' : '#CBD5E1' }}; color: white; padding: 6px 12px; border-radius: 4px;">
                                        {{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}
                                    </span>
                                </td>
                                <td style="padding: 16px;">
                                    <a href="{{ route('admin.contact.show', $contact->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; text-decoration: none; padding: 6px 12px; border-radius: 6px;">
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
