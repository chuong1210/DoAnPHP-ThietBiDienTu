@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">
    <!-- Tech Blue header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; padding: 28px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 102, 255, 0.2);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 9V5a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h2m4-11v6"/><circle cx="13" cy="17" r="3"/><circle cx="20" cy="17" r="3"/>
            </svg>
            <h1 class="h3 mb-0">Chi tiết liên hệ #{{ $contact->id }}</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 750px; margin: 0 auto; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); overflow: hidden;">
        <div class="card-body" style="padding: 0;">
            <div style="display: grid; gap: 0;">
                <!-- ID -->
                <div style="padding: 20px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 16px;">
                    <div style="background: #0066FF; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                        ID
                    </div>
                    <div>
                        <p style="margin: 0; color: #64748B; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Mã liên hệ</p>
                        <p style="margin: 0; color: #1E293B; font-size: 16px; font-weight: 600;">#{{ $contact->id }}</p>
                    </div>
                </div>

                <!-- Tên -->
                <div style="padding: 20px; background-color: #FFFFFF; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 16px;">
                    <div style="background: #10B981; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p style="margin: 0; color: #64748B; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Khách hàng</p>
                        <p style="margin: 0; color: #1E293B; font-size: 16px; font-weight: 600;">{{ $contact->name }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div style="padding: 20px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 16px;">
                    <div style="background: #8B5CF6; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <p style="margin: 0; color: #64748B; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Email liên hệ</p>
                        <p style="margin: 0; color: #0066FF; font-size: 15px; font-weight: 500;">{{ $contact->email }}</p>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div style="padding: 20px; background-color: #FFFFFF; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; gap: 16px;">
                    <div style="background: {{ $contact->status == 'new' ? '#F59E0B' : '#10B981' }}; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div>
                        <p style="margin: 0; color: #64748B; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Trạng thái</p>
                        <span class="badge" style="background-color: {{ $contact->status == 'new' ? '#F59E0B' : '#10B981' }}; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 600;">
                            {{ $contact->status == 'new' ? 'Chưa trả lời' : 'Đã trả lời' }}
                        </span>
                    </div>
                </div>

                <!-- Nội dung -->
                <div style="padding: 20px; background-color: #F8FAFC; display: flex; gap: 16px;">
                    <div style="background: #FF6B6B; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; color: #64748B; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Nội dung câu hỏi</p>
                        <div style="margin-top: 8px; padding: 16px; background: white; border-radius: 8px; border: 1px solid #E2E8F0; font-size: 15px; line-height: 1.7; color: #1E293B;">
                            {{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($contact->status == 'new')
    <div class="card shadow-sm mt-4" style="border: 1px solid #CBD5E1; border-radius: 12px; max-width: 750px; margin: 0 auto; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); overflow: hidden;">
        <div class="card-header" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 20px; border-radius: 11px 11px 0 0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 18 0 9 9 0 1 0 -18 0M9 12h6M12 9v6"/>
                </svg>
                <h5 class="mb-0" style="font-weight: 600;">Trả lời khách hàng</h5>
            </div>
        </div>
        <div class="card-body" style="padding: 28px; background: #FFFFFF;">
            <form action="{{ route('admin.contact.send', $contact->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="subject" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px; font-size: 15px;">Tiêu đề email</label>
                    <input type="text" class="form-control" name="subject" id="subject" value="Phản hồi từ Shop" style="border-color: #CBD5E1; border-radius: 10px; padding: 12px 16px; font-size: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="form-label" style="color: #1E293B; font-weight: 600; margin-bottom: 10px; font-size: 15px;">Nội dung phản hồi</label>
                    <textarea class="form-control" name="message" id="message" rows="6" style="border-color: #CBD5E1; border-radius: 10px; padding: 12px 16px; font-size: 15px; resize: vertical; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" required></textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="btn flex-grow-1" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 14px 20px; border-radius: 10px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);">
                        <i class="fas fa-paper-plane"></i> Gửi email ngay
                    </button>
                    <a href="{{ route('admin.contact.index') }}" class="btn" style="background-color: #E0F2FE; color: #0066FF; border: 1px solid #0066FF; padding: 14px 20px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 15px;">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="mt-4 text-center">
        <a href="{{ route('admin.contact.index') }}" class="btn" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 15px; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
    @endif
</div>
@endsection
