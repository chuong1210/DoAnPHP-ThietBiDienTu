<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'quantity'    => 'required|integer|min:0',
            'description' => 'nullable',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images'      => 'nullable|array', // Validate images là một mảng
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validate từng file trong mảng
            'status'      => 'required|in:active,inactive',
            'is_featured' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $data = $validated;
            $data['slug'] = Str::slug($data['name']);
            $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

            // Xử lý upload ảnh đại diện
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = 'product_main_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);
                $data['image'] = 'images/' . $fileName;
            }

            // Xử lý upload nhiều ảnh bổ sung
            if ($request->hasFile('images')) {
                $uploadedImages = [];
                foreach ($request->file('images') as $imageFile) {
                    $imageName = 'product_extra_' . time() . '_' . Str::random(4) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('images'), $imageName);
                    $uploadedImages[] = 'images/' . $imageName;
                }
                // GÁN TRỰC TIẾP MẢNG, KHÔNG CẦN json_encode
                $data['images'] = $uploadedImages;
            } else {
                // Nếu không upload ảnh mới, đảm bảo nó là một mảng rỗng
                $data['images'] = [];
            }

            $this->productRepository->create($data);
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
