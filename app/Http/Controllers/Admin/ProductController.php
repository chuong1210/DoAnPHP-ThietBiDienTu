<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $products = $this->productRepository->searchAndPaginateProduct(
            $request,
            20, // Số sản phẩm mỗi trang
            ['category', 'brand'] // Các relationship cần load
        );

        // Lấy danh sách categories và brands cho bộ lọc sử dụng repository
        $categories = $this->categoryRepository->getActiveCategories_2();
        $brands = $this->brandRepository->getActiveBrands_2();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Hiển thị form thêm sản phẩm mới
     * GET /admin/products/create
     */
    public function create()
    {
        // Lấy danh sách categories và brands cho form sử dụng repository
        $categories = $this->categoryRepository->getActiveCategories_2();
        $brands = $this->brandRepository->getActiveBrands_2();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Lưu sản phẩm mới vào database
     * POST /admin/products
     */
    public function store(Request $request)
    {
        // === DEBUG: Kiểm tra xem file có được gửi lên không ===
        // dd($request->hasFile('image'), $request->file('image'), $request->all());

        $validated = $request->validate([
            'name'        => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'quantity'    => 'required|integer|min:0',
            'description' => 'nullable',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'required|in:active,inactive',
            'is_featured' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            // Chuẩn bị data
            $data = [
                'name'        => $validated['name'],
                'category_id' => $validated['category_id'],
                'brand_id'    => $validated['brand_id'],
                'price'       => $validated['price'],
                'sale_price'  => $validated['sale_price'] ?? null,
                'quantity'    => $validated['quantity'],
                'description' => $validated['description'] ?? null,
                'status'      => $validated['status'],
                'slug'        => Str::slug($validated['name']),
                'is_featured' => $request->has('is_featured') ? 1 : 0,
            ];

            // === XỬ LÝ ẢNH ĐẠI DIỆN ===
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');
                $fileName = 'product_main_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

                // Đảm bảo thư mục tồn tại
                $imagePath = public_path('images');
                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0755, true);
                }

                $file->move($imagePath, $fileName);
                $data['image'] = 'images/' . $fileName;
            }

            // === XỬ LÝ NHIỀU ẢNH BỔ SUNG ===
            $uploadedImages = [];
            if ($request->hasFile('images')) {
                $imagePath = public_path('images');
                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0755, true);
                }

                foreach ($request->file('images') as $imageFile) {
                    if ($imageFile->isValid()) {
                        $imageName = 'product_extra_' . time() . '_' . Str::random(6) . '.' . $imageFile->getClientOriginalExtension();
                        $imageFile->move($imagePath, $imageName);
                        $uploadedImages[] = 'images/' . $imageName;
                    }
                }
            }

            // Gán mảng ảnh (Laravel tự động cast sang JSON nếu field là json/array trong migration)
            $data['images'] = $uploadedImages;

            // Tạo sản phẩm
            $product = $this->productRepository->create($data);

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error để debug
            Log::error('Product Store Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

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
        $categories = $this->categoryRepository->getActiveCategories_2();
        $brands = $this->brandRepository->getActiveBrands_2();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Cập nhật sản phẩm
     * PUT /admin/products/{id}
     */
    public function update(Request $request, $id)
    {
        $product = $this->productRepository->findById($id);

        $validated = $request->validate([
            'name'        => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            // ... các validation khác tương tự store()
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'      => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $validated;
            $data['slug'] = STR::slug($data['name']);
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // Xử lý upload ảnh đại diện mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
                // Upload ảnh mới
                $file = $request->file('image');
                $fileName = 'product_main_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);
                $data['image'] = 'images/' . $fileName;
            }

            // --- LOGIC XỬ LÝ NHIỀU ẢNH KHI UPDATE ---

            // 1. Lấy danh sách ảnh cũ còn lại (sau khi người dùng có thể đã xóa)
            $remainingOldImages = $request->input('old_images', []);

            // 2. Xác định các ảnh cũ bị xóa và xóa file trên server
            $currentImages = $product->images ? (is_array($product->images) ? $product->images : json_decode($product->images, true)) : [];
            $deletedImages = array_diff($currentImages, $remainingOldImages);

            foreach ($deletedImages as $deletedImage) {
                if (file_exists(public_path($deletedImage))) {
                    unlink(public_path($deletedImage));
                }
            }

            // 3. Upload các ảnh mới (nếu có)
            $newUploadedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $imageName = 'product_extra_' . time() . '_' . Str::random(4) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('images'), $imageName);
                    $newUploadedImages[] = 'images/' . $imageName;
                }
            }

            // 4. Hợp nhất ảnh cũ còn lại và ảnh mới upload
            $finalImages = array_merge($remainingOldImages, $newUploadedImages);

            // 5. Chuyển thành JSON để lưu
            // $data['images'] = json_encode($finalImages);
            $data['images'] = $finalImages;


            // ------------------------------------------

            $this->productRepository->update($id, $data);
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
            // Xóa ảnh đại diện
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Xóa nhiều ảnh bổ sung
            // Kiểm tra xem $product->images có phải là mảng và không rỗng không
            if (is_array($product->images) && !empty($product->images)) {
                // Lặp trực tiếp qua mảng, không cần json_decode()
                foreach ($product->images as $imagePath) {
                    if (file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
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
