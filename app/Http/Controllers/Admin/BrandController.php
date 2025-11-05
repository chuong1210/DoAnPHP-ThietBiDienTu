<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     * Hiển thị danh sách thương hiệu, hỗ trợ tìm kiếm và phân trang.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $brands = $this->brandRepository->searchAndPaginate('name', $keyword);

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form để tạo mới thương hiệu.
     */
    public function create()
    {
        return view('admin.brands.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:brands,name',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $validated;
            $data['slug'] = Str::slug($data['name']);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $fileName = 'brand_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // SỬA LẠI ĐÂY: Lưu trực tiếp vào public/images
                $file->move(public_path('images'), $fileName);
                $data['logo'] = 'images/' . $fileName;
            }

            $this->brandRepository->create($data);
            DB::commit();

            return redirect()->route('admin.brands.index')
                ->with('success', 'Thêm thương hiệu mới thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')
                ->withInput();
        }
    }

    // ... hàm show() và edit() giữ nguyên ...
    public function show(string $id)
    {
        return redirect()->route('admin.brands.edit', $id);
    }

    public function edit(string $id)
    {
        $brand = $this->brandRepository->findById($id);
        if (!$brand) {
            return redirect()->route('admin.brands.index')->with('error', 'Không tìm thấy thương hiệu.');
        }
        return view('admin.brands.edit', compact('brand'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = $this->brandRepository->findById($id);
        if (!$brand) {
            return redirect()->route('admin.brands.index')->with('error', 'Không tìm thấy thương hiệu.');
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:brands,name,' . $id,
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $validated;
            $data['slug'] = Str::slug($data['name']);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            if ($request->hasFile('logo')) {
                // Xóa logo cũ
                if ($brand->logo && file_exists(public_path($brand->logo))) {
                    unlink(public_path($brand->logo));
                }

                $file = $request->file('logo');
                $fileName = 'brand_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // SỬA LẠI ĐÂY: Lưu trực tiếp vào public/images
                $file->move(public_path('images'), $fileName);
                $data['logo'] = 'images/' . $fileName;
            }

            $this->brandRepository->update($id, $data);
            DB::commit();

            return redirect()->route('admin.brands.index')
                ->with('success', 'Cập nhật thương hiệu thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hàm destroy không cần sửa vì unlink(public_path($brand->logo))
        // hoạt động dựa trên đường dẫn đã lưu trong DB,
        // mà đường dẫn này đã được sửa ở store/update.
        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->findById($id);
            if (!$brand) {
                return redirect()->route('admin.brands.index')->with('error', 'Không tìm thấy thương hiệu.');
            }

            if ($brand->products()->count() > 0) {
                return redirect()->route('admin.brands.index')
                    ->with('error', 'Không thể xóa thương hiệu này vì đang có sản phẩm sử dụng.');
            }

            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }

            $this->brandRepository->delete($id);
            DB::commit();

            return redirect()->route('admin.brands.index')
                ->with('success', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đã có lỗi xảy ra khi xóa. Vui lòng thử lại.');
        }
    }
}
