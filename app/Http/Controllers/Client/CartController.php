<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Repositories\BrandRepository;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected $cartRepository;
    protected $cartItemRepository;
    protected $productRepository;
    protected $categoryRepository;
    protected $categoryService;

    protected $brandRepository;
    protected $brandService;
    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
    }




    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $userId = Auth::id();
        $cart = $this->cartRepository->findByCondition(
            [['user_id', '=', $userId]],
            false,
            ['items.product.brand']
        );
        $categories = $this->categoryRepository->getCategoriesWithChildren();
        $brands = $this->brandRepository->getActiveBrands();
        $coupons = Coupon::active()->get(); // Load active coupons

        return view('client.cart.index', compact('cart', 'categories', 'brands', 'coupons'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $quantity = $request->quantity;

        // Lấy sản phẩm sử dụng repository
        $product = $this->productRepository->findById($productId);

        // Kiểm tra tồn kho
        if ($product->quantity < $quantity) {
            return back()->with('error', 'Sản phẩm không đủ số lượng trong kho');
        }

        DB::beginTransaction();
        try {
            // Lấy hoặc tạo giỏ hàng sử dụng repository
            $cart = $this->cartRepository->createOrGetCart($userId);

            // Thêm hoặc cập nhật item sử dụng repository
            $this->cartItemRepository->addOrUpdateItem(
                $cart->id,
                $productId,
                $quantity,
                $product->sale_price ?? $product->price
            );

            DB::commit();

            return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật số lượng
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        // Kiểm tra quyền sở hữu và lấy item
        $cartItem = $this->cartItemRepository->findByCondition(
            [['id', '=', $itemId]],
            false,
            [],
            null
        );

        // Thêm check whereHas cho cart.user_id (vì BaseRepository không hỗ trợ trực tiếp, giữ query simple check)
        if (!$cartItem || $cartItem->cart->user_id !== $userId) {
            abort(404);
        }

        $product = $cartItem->product;

        // Kiểm tra tồn kho
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Sản phẩm không đủ số lượng trong kho (còn ' . $product->quantity . ')');
        }

        // Cập nhật sử dụng repository
        $this->cartItemRepository->update($itemId, ['quantity' => $request->quantity]);

        return back()->with('success', 'Đã cập nhật số lượng');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove($itemId)
    {
        $userId = Auth::id();

        // Kiểm tra quyền sở hữu và lấy item
        $cartItem = $this->cartItemRepository->findByCondition(
            [['id', '=', $itemId]],
            false,
            [],
            null
        );

        // Thêm check whereHas cho cart.user_id
        if (!$cartItem || $cartItem->cart->user_id !== $userId) {
            abort(404);
        }

        // Xóa sử dụng repository
        $this->cartItemRepository->delete($itemId);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        $userId = Auth::id();

        // Xóa toàn bộ sử dụng repository
        $this->cartRepository->clearCart($userId);

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
}
