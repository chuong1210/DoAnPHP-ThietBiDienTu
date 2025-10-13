<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $brandRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Hiển thị danh sách sản phẩm
     * GET /admin/products
     */
    public function index(Request $request)
    {
        $conditions = [
            'keyword' => $request->keyword,
            'where' => []
        ];

        // Lọc theo danh mục
        if ($request->has('category_id') && !empty($request->category_id)) {
            $conditions['where'][] = ['category_id', '=', $request->category_id];
        }

        // Lọc theo thương hiệu
        if ($request->has('brand_id') && !empty($request->brand_id)) {
            $conditions['where'][] = ['brand_id', '=', $request->brand_id];
        }

        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $conditions['where'][] = ['status', '=', $request->status];
        }

        // Phân trang sử dụng repository
        $products = $this->productRepository->pagination(
            ['*'],
            $conditions,
            20,
            [],
            ['category', 'brand'],
            ['id', 'DESC']
        );

        // Lấy danh sách categories và brands cho bộ lọc sử dụng repository
        $categories = $this->categoryRepository->getActiveCategories();
        $brands = $this->brandRepository->getActiveBrands();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Hiển thị form thêm sản phẩm mới
     * GET /admin/products/create
     */
    public function create()
    {
        // Lấy danh sách categories và brands cho form sử dụng repository
        $categories = $this->categoryRepository->getActiveCategories();
        $brands = $this->brandRepository->getActiveBrands();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Lưu sản phẩm mới vào database
     * POST /admin/products
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'brand_id.exists' => 'Thương hiệu không tồn tại',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số',
            'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'quantity.required' => 'Số lượng không được để trống',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'image.image' => 'File phải là ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'image.max' => 'Ảnh không được vượt quá 2MB',
        ]);

        DB::beginTransaction();
        try {
            // Tạo slug từ tên
            $validated['slug'] = str()->slug($validated['name']);

            // Xử lý upload ảnh đại diện
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . str()->random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/'), $imageName);
                $validated['image'] = 'images/' . $imageName; // ✔ lưu kèm thư mục

            }

            // Xử lý upload nhiều ảnh
            if ($request->hasFile('images')) {
                $uploadedImages = [];
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . str()->random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/'), $imageName);
                    $uploadedImages[] = 'images/' . $imageName; // ✔ Lưu kèm folder
                }
                $validated['images'] = json_encode($uploadedImages);
            }

            // Xử lý checkbox is_featured
            $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // Tạo sản phẩm sử dụng repository
            $this->productRepository->create($validated);

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết sản phẩm
     * GET /admin/products/{id}
     */
    public function show($id)
    {
        $product = $this->productRepository->findById($id, ['*'], ['category', 'brand', 'reviews.user']);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Hiển thị form sửa sản phẩm
     * GET /admin/products/{id}/edit
     */
    public function edit($id)
    {
        $product = $this->productRepository->findById($id);

        // Lấy danh sách categories và brands cho form sử dụng repository
        $categories = $this->categoryRepository->getActiveCategories();
        $brands = $this->brandRepository->getActiveBrands();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Cập nhật sản phẩm
     * PUT /admin/products/{id}
     */
    public function update(Request $request, $id)
    {
        $product = $this->productRepository->findById($id);

        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'price.required' => 'Giá sản phẩm không được để trống',
            'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'quantity.required' => 'Số lượng không được để trống',
        ]);

        DB::beginTransaction();
        try {
            // Cập nhật slug nếu đổi tên
            $validated['slug'] = str()->slug($validated['name']);

            // Xử lý upload ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }

                // Upload ảnh mới
                $image = $request->file('image');
                $imageName = time() . '_' . str()->random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/'), $imageName);
                $validated['image'] = 'images/' . $imageName; // ✔ lưu kèm thư mục

            }

            // Xử lý checkbox is_featured
            $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // Cập nhật sản phẩm sử dụng repository
            $this->productRepository->update($id, $validated);

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Xóa sản phẩm
     * DELETE /admin/products/{id}
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->findById($id);

            // Xóa ảnh
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Xóa nhiều ảnh
            if ($product->images) {
                $images = json_decode($product->images, true);
                foreach ($images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image));
                    }
                }
            }

            // Xóa sản phẩm sử dụng repository
            $this->productRepository->delete($id);

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Xóa sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
