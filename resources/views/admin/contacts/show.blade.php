@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid" style="background-color: #FFF5F7; min-height: 100vh; padding: 20px 0;">
    <!-- Updated header styling -->
    <div class="mb-4" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; padding: 25px; border-radius: 8px;">
        <h1 class="h3 mb-0">🔍 Chi tiết câu hỏi</h1>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 700px; margin: 0 auto;">
        <div class="card-body">
            <table class="table" style="border-color: #F0D9DE;">
                <tr style="border-bottom: 1px solid #F0D9DE;">
                    <th style="background-color: #FFF5F7; color: #1E293B; width: 30%;">ID</th>
                    <td style="color: #1E293B;">{{ $contact->id }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #F0D9DE;">
                    <th style="background-color: #FFF5F7; color: #1E293B;">Tên</th>
                    <td style="color: #1E293B;">{{ $contact->name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #F0D9DE;">
                    <th style="background-color: #FFF5F7; color: #1E293B;">Email</th>
                    <td style="color: #FF3B3F;">{{ $contact->email }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #F0D9DE;">
                    <th style="background-color: #FFF5F7; color: #1E293B;">Trạng thái</th>
                    <td>
                        <span class="badge" style="background-color: {{ $contact->status == 'new' ? '#FF99AC' : '#FFD4DC' }}; color: #1E293B;">
                            {{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: #FFF5F7; color: #1E293B;">Nội dung câu hỏi</th>
                    <td style="color: #1E293B;">{{ $contact->message }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($contact->status == 'new')
    <div class="card shadow-sm mt-4" style="border: 1px solid #F0D9DE; border-radius: 8px; max-width: 700px; margin: 0 auto;">
        <div class="card-header" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
            <h5 class="mb-0">💬 Trả lời khách hàng</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contact.send', $contact->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject" class="form-label" style="color: #1E293B; font-weight: 500;">Tiêu đề email</label>
                    <input type="text" class="form-control" name="subject" id="subject" value="Phản hồi từ Shop" style="border-color: #F0D9DE;" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label" style="color: #1E293B; font-weight: 500;">Nội dung phản hồi</label>
                    <textarea class="form-control" name="message" id="message" rows="5" style="border-color: #F0D9DE;" required></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #FF3B3F 0%, #FF6B81 100%); color: white; border: none;">
                        <i class="fas fa-paper-plane"></i> Gửi email
                    </button>
                    <a href="{{ route('admin.contact.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="mt-4" style="text-align: center;">
        <a href="{{ route('admin.contact.index') }}" class="btn" style="background-color: #F0D9DE; color: #1E293B; border: none; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
    @endif
</div>
@endsection
