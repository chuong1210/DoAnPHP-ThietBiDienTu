@extends('admin.layouts.admin')

@section('title', 'Quản Lý Banner')
@section('page-title', 'Quản Lý Banner')

@section('content')
    <div class="container-fluid" style="background: linear-gradient(135deg, #F8FAFC 0%, #E0F2FE 100%); min-height: 100vh; padding: 20px 0;">

        <!-- Add Button -->
        <a href="{{ route('admin.banners.create') }}" class="btn btn-lg mb-4" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 500;">
            <i class="fas fa-plus"></i> Thêm Banner
        </a>

        <!-- Banner Table with modern design -->
        <div class="card shadow-sm" style="border: 1px solid #CBD5E1; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="border-color: #CBD5E1;">
                        <thead style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white;">
                            <tr>
                                <th style="padding: 16px; font-weight: 600;">ID</th>
                                <th style="padding: 16px; font-weight: 600;">Tiêu đề</th>
                                <th style="padding: 16px; font-weight: 600;">Hình ảnh</th>
                                <th style="padding: 16px; font-weight: 600;">Liên kết</th>
                                <th style="padding: 16px; font-weight: 600;">Thứ tự</th>
                                <th style="padding: 16px; font-weight: 600;">Trạng thái</th>
                                <th style="padding: 16px; font-weight: 600;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $banner)
                                <tr style="border-bottom: 1px solid #CBD5E1; transition: background-color 0.2s;">
                                    <td style="color: #1E293B; padding: 16px;">{{ $banner->id }}</td>
                                    <td style="color: #1E293B; font-weight: 500; padding: 16px;">{{ $banner->title }}</td>
                                    <td style="padding: 16px;">
                                        @if ($banner->image && file_exists(public_path('images/' . $banner->image)))
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $banner->id }}">
                                                <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 80px; height: 60px; object-fit: cover; border-radius: 6px; border: 2px solid #E0F2FE;">
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal{{ $banner->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content" style="border: 1px solid #CBD5E1; border-radius: 12px;">
                                                        <div class="modal-header" style="background: linear-gradient(135deg, #0066FF 0%, #00B4D8 100%); color: white; border: none; padding: 20px;">
                                                            <h5 class="modal-title" id="imageModalLabel{{ $banner->id }}">{{ $banner->title }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center" style="background-color: #F8FAFC; padding: 24px;">
                                                            <img src="{{ asset('images/' . $banner->image) }}" alt="{{ $banner->title }}" style="max-width: 100%; height: auto; border-radius: 8px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span style="color: #0066FF; font-size: 13px;">Ảnh không tồn tại</span>
                                        @endif
                                    </td>
                                    <td style="color: #1E293B; padding: 16px;">
                                        @if ($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank" style="color: #0066FF; text-decoration: none; font-size: 13px;">{{ \Illuminate\Support\Str::limit($banner->link, 20) }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td style="color: #1E293B; padding: 16px;">{{ $banner->sort_order }}</td>
                                    <td style="padding: 16px;">
                                        <span class="badge" style="background-color: {{ $banner->is_active ? '#00B4D8' : '#CBD5E1' }}; color: white; padding: 6px 12px; border-radius: 4px;">
                                            {{ $banner->is_active ? 'Hiển thị' : 'Ẩn' }}
                                        </span>
                                    </td>
                                    <td style="padding: 16px; display: flex; gap: 8px;">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm" style="background: #ffedd5; color: #991b1b; border: none; text-decoration: none; padding: 6px 12px; border-radius: 6px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background-color: #fee2e2 ; color: #991b1b ; border: none; padding: 6px 12px; border-radius: 6px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center" style="color: #1E293B; padding: 24px;">
                                        <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5">
                                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/>
                                            </svg>
                                            Không có banner nào
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="padding: 16px; border-top: 1px solid #CBD5E1; background-color: #F8FAFC;">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
