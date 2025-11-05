<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner; // Sử dụng Model trực tiếp
use App\Repositories\BannerRepository; // Giả sử bạn vẫn dùng repo cho các hàm khác
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    protected $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request)
    {
        // Giữ nguyên logic index của bạn
        $condition = [];
        if ($request->has('keyword') && !empty($request->keyword)) {
            $condition['keyword'] = $request->keyword;
        }

        $banners = $this->bannerRepository->pagination(
            ['id', 'title', 'image', 'link', 'sort_order', 'is_active', 'created_at'],
            $condition,
            10
        );

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        // Đếm số lượng banner đang hoạt động để tạo dropdown
        $activeBannerCount = Banner::where('is_active', true)->count();

        // Số thứ tự mới sẽ là số lượng hiện tại + 1
        $nextSortOrder = $activeBannerCount + 1;

        return view('admin.banners.create', compact('activeBannerCount', 'nextSortOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link'        => 'nullable|url',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        // Gán giá trị mặc định cho sort_order nếu rỗng
        $data['sort_order'] = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'banner_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

            // Di chuyển file vào thư mục public/images
            $file->move(public_path('images'), $fileName);

            // SỬA LẠI ĐÂY: Thêm tiền tố 'images/'
            $data['image'] = 'images/' . $fileName;
        }

        // Sử dụng Model để tạo mới
        $banner = Banner::create($data);

        return redirect()
            ->route('admin.banners.index') // Nên chuyển về trang danh sách sau khi tạo
            ->with('success', 'Thêm banner thành công!');
    }

    public function edit($id)
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            return redirect()->route('admin.banners.index')->with('error', 'Không tìm thấy banner.');
        }

        // Đếm số lượng banner đang hoạt động
        $activeBannerCount = Banner::where('is_active', true)->count();

        return view('admin.banners.edit', compact('banner', 'activeBannerCount'));
    }

    public function update(Request $request, $id)
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            return redirect()->route('admin.banners.index')->with('error', 'Không tìm thấy banner.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->only(['title', 'link', 'sort_order']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($banner->image && file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            $file = $request->file('image');
            $filename = 'banner_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            // SỬA LẠI ĐÂY: Thêm tiền tố 'images/'
            $data['image'] = 'images/' . $filename;
        }

        $this->bannerRepository->update($id, $data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $banner = $this->bannerRepository->findById($id);
        if (!$banner) {
            return redirect()->route('admin.banners.index')->with('error', 'Không tìm thấy banner.');
        }

        // Logic xóa ảnh đã đúng vì nó đọc đường dẫn từ DB
        if ($banner->image && file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }

        $this->bannerRepository->delete($id);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được xóa thành công.');
    }
}
