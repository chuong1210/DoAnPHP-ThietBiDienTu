<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Str;

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

    // Form thêm mới
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = str()->slug($validated['name']);

        $this->categoryRepository->create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công!');
    }

    // Hiển thị chi tiết
    public function show($id)
    {
        $category = $this->categoryRepository->findById($id);

        return view('admin.categories.show', compact('category'));
    }

    // Form sửa
    public function edit($id)
    {
        $category = $this->categoryRepository->findById($id);

        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = str()->slug($validated['name']);

        $this->categoryRepository->update($id, $validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xóa
    public function destroy($id)
    {
        $this->categoryRepository->delete($id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
