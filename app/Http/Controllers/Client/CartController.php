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
use Illuminate\Support\Facades\Log;

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
            'buy_now'  => 'nullable|in:1',
        ]);

        $userId = Auth::id();
        $quantity = $request->input('quantity', 1);
        $isBuyNow = $request->has('buy_now');

        $product = $this->productRepository->findById($productId);
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        if ($product->quantity < $quantity) {
            return back()->with('error', 'Sản phẩm không đủ số lượng (còn ' . $product->quantity . ')');
        }

        DB::beginTransaction();
        try {
            $cart = $this->cartRepository->createOrGetCart($userId);

            if ($isBuyNow) {
                // XÓA SẠCH GIỎ → CHỈ GIỮ 1 SẢN PHẨM
                $cart->items()->delete();
            }

            // Thêm hoặc cập nhật item
            $this->cartItemRepository->addOrUpdateItem(
                $cart->id,
                $productId,
                $quantity,
                $product->sale_price ?? $product->price
            );

            DB::commit();

            if ($isBuyNow) {
                return redirect()->route('client.checkout.index')
                    ->with('success', 'Chuyển đến thanh toán ngay!');
            }

            return back()->with('success', 'Đã thêm vào giỏ hàng');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add to cart error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
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
