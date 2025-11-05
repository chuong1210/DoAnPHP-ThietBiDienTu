<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // Hiển thị danh sách
    public function index()
    {
        $categories = $this->categoryRepository->pagination(
            ['*'],
            [],
            10,
            [],
            [],
            ['id', 'DESC']
        );

        return view('admin.categories.index', compact('categories'));
    }


    /**
     * Hiển thị form thêm mới.
     */
    public function create()
    {
        // Lấy danh sách các danh mục có thể làm cha
        $parentCategories = $this->categoryRepository->getParentCategories();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Lưu danh mục mới.
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:categories,name',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique'   => 'Tên danh mục này đã tồn tại.',
            'parent_id.exists' => 'Danh mục cha không hợp lệ.',
            'image.*'       => 'Tệp tải lên cho ảnh không hợp lệ.',
        ]);

        DB::beginTransaction();
        try {
            // 2. Xử lý dữ liệu
            $data = $validated;
            $data['slug'] = STR::slug($data['name']);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            // Nếu không có parent_id, đảm bảo nó là null
            $data['parent_id'] = $request->parent_id ?: null;

            // 3. Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = 'category_' . time() . '_' . STR::random(8) . '.' . $file->getClientOriginalExtension();
                // Lưu trực tiếp vào public/images
                $file->move(public_path('images'), $fileName);
                $data['image'] = 'images/' . $fileName;
            }

            // 4. Gọi repository để tạo
            $this->categoryRepository->create($data);
            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Thêm danh mục thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết (thường không cần thiết, chuyển đến edit).
     */
    public function show($id)
    {
        return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Hiển thị form sửa.
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Không tìm thấy danh mục.');
        }

        // Lấy danh sách các danh mục cha, loại trừ chính nó và các con của nó
        $parentCategories = $this->categoryRepository->getParentCategories($id);

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Cập nhật danh mục.
     */
    public function update(Request $request, $id)
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Không tìm thấy danh mục.');
        }

        // 1. Validate dữ liệu
        $validated = $request->validate([
            'name'      => 'required|string|max:100|unique:categories,name,' . $id,
            // Đảm bảo không thể chọn chính nó hoặc con của nó làm cha
            'parent_id' => 'nullable|integer|exists:categories,id|not_in:' . $id,
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        // (Tùy chọn nâng cao) Kiểm tra để ngăn chặn việc đặt một danh mục cha làm con của chính nó
        if ($request->parent_id) {
            $parent = $this->categoryRepository->findById($request->parent_id);
            if ($parent && $parent->parent_id == $id) {
                return back()->withInput()->with('error', 'Không thể đặt danh mục cha làm con của chính nó.');
            }
        }

        DB::beginTransaction();
        try {
            // 2. Xử lý dữ liệu
            $data = $validated;
            $data['slug'] = STR::slug($data['name']);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['parent_id'] = $request->parent_id ?: null;

            // 3. Xử lý upload ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu tồn tại
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $file = $request->file('image');
                $fileName = 'category_' . time() . '_' . STR::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);
                $data['image'] = 'images/' . $fileName;
            }

            // 4. Gọi repository để cập nhật
            $this->categoryRepository->update($id, $data);
            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Cập nhật danh mục thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Xóa danh mục.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->findById($id);
            if (!$category) {
                return redirect()->route('admin.categories.index')->with('error', 'Không tìm thấy danh mục.');
            }

            // Xóa ảnh
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            // Gọi repository để xóa
            $this->categoryRepository->delete($id);
            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Nếu có lỗi khóa ngoại (do sản phẩm đang dùng), bắt lỗi và thông báo
            if (str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục này vì đang có sản phẩm hoặc danh mục con sử dụng.');
            }
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa.');
        }
    }
}
