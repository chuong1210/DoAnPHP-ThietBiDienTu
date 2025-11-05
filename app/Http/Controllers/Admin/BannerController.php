<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'link'        => 'nullable|url',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        }

        $banner = \App\Models\Banner::create($data);

        return redirect()
            ->route('admin.banners.edit', $banner->id)  // ← CHUYỂN NGAY VỀ EDIT
            ->with('success', 'Thêm banner thành công! Bạn có thể xem hoặc chỉnh sửa ngay.');
    }

    public function edit($id)
    {
        $banner = $this->bannerRepository->findById($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['title', 'link', 'sort_order', 'is_active']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $banner = $this->bannerRepository->findById($id);
            if ($banner->image && file_exists(public_path('images/' . $banner->image))) {
                unlink(public_path('images/' . $banner->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        $this->bannerRepository->update($id, $data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $banner = $this->bannerRepository->findById($id);
        if ($banner->image && file_exists(public_path('images/' . $banner->image))) {
            unlink(public_path('images/' . $banner->image));
        }

        $this->bannerRepository->delete($id);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được xóa thành công.');
    }
}
