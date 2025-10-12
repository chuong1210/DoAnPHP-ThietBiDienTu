<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll($perPage = 20)
    {
        return $this->productRepository->pagination(['*'], [], $perPage, [], ['category', 'brand']);
    }

    public function search($keyword, $filters = [])
    { {
            return $this->productRepository->searchProducts($keyword, $filters);
        }
    }

    public function getById($id)
    {
        // Tăng view count
        DB::table('products')->where('id', $id)->increment('view_count');

        return $this->productRepository->findById($id, ['*'], ['category', 'brand', 'reviews.user']);
    }



    /**
     * Lấy danh sách sản phẩm có phân trang
     */
    public function getAllProducts($perPage = 20)
    {
        return $this->productRepository->pagination([], null, $perPage);
    }

    /**
     * Lấy chi tiết sản phẩm
     */
    public function getProductById($id)
    {
        $product = $this->productRepository->findById($id);

        // Tăng lượt xem
        $product->increment('view_count');

        return $product;
    }

    /**
     * Tạo sản phẩm mới
     */
    public function createProduct($data)
    {
        DB::beginTransaction();
        try {
            // Xử lý upload ảnh
            if (isset($data['image']) && $data['image']) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            // Xử lý upload nhiều ảnh
            if (isset($data['images']) && is_array($data['images'])) {
                $uploadedImages = [];
                foreach ($data['images'] as $image) {
                    $uploadedImages[] = $this->uploadImage($image);
                }
                $data['images'] = json_encode($uploadedImages);
            }

            $product = $this->productRepository->create($data);

            DB::commit();
            return ['success' => true, 'product' => $product];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct($id, $data)
    {
        DB::beginTransaction();
        try {
            // Lấy sản phẩm hiện tại
            $product = $this->productRepository->findById($id);

            // Xử lý upload ảnh mới
            if (isset($data['image']) && $data['image']) {
                // Xóa ảnh cũ
                if ($product->image) {
                    $this->deleteImage($product->image);
                }
                $data['image'] = $this->uploadImage($data['image']);
            }

            $product = $this->productRepository->update($id, $data);

            DB::commit();
            return ['success' => true, 'product' => $product];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->findById($id);

            // Xóa ảnh
            if ($product->image) {
                $this->deleteImage($product->image);
            }

            $this->productRepository->delete($id);

            DB::commit();
            return ['success' => true];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function searchProducts($keyword, $filters = [])
    {
        return $this->productRepository->searchProducts($keyword, $filters);
    }

    /**
     * Upload ảnh
     */
    private function uploadImage($file)
    {
        if ($file) {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $fileName);
            return $fileName;
        }
        return null;
    }

    /**
     * Xóa ảnh
     */
    private function deleteImage($fileName)
    {
        $filePath = public_path('images/products/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
