<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    protected $productRepository;
    protected $reviewRepository;

    public function __construct(
        ProductRepository $productRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Hiển thị form đánh giá sản phẩm (chỉ nếu đã mua)
     * GET /products/{slug}/review
     */
    public function create($slug)
    {
        $product = $this->productRepository->getProductBySlug($slug);

        // Kiểm tra user đã mua chưa (sử dụng logic từ repository)
        try {
            $hasOrdered = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.user_id', Auth::id())
                ->where('order_items.product_id', $product->id)
                ->where('orders.status', 'delivered')
                ->exists();

            if (!$hasOrdered) {
                return redirect()->route('client.product.show', $slug)
                    ->with('error', 'Bạn chưa mua sản phẩm này để có thể đánh giá.');
            }

            // Kiểm tra đã review chưa
            $existingReview = $this->reviewRepository->findByCondition(
                [['product_id', '=', $product->id], ['user_id', '=', Auth::id()]],
                false
            );

            if ($existingReview) {
                return redirect()->route('client.product.show', $slug)
                    ->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
            }

            return view('client.reviews.create', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('client.product.show', $slug)
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lưu đánh giá mới
     * POST /products/{slug}/review
     */
    public function store(Request $request, $slug)
    {
        $product = $this->productRepository->getProductBySlug($slug);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn điểm đánh giá.',
            'rating.integer' => 'Điểm đánh giá phải là số nguyên từ 1-5.',
            'comment.max' => 'Nhận xét không được vượt quá 1000 ký tự.',
        ]);

        $validated['product_id'] = $product->id;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; // Chờ admin duyệt

        try {
            $this->reviewRepository->createReview($validated);

            return redirect()->route('client.product.show', $slug)
                ->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Hiển thị danh sách đánh giá của user (profile)
     * GET /profile/reviews
     */
    // public function userReviews()
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập.');
    //     }

    //     $reviews = $this->reviewRepository->getReviewsByUser(Auth::id());

    //     return view('client.profile.reviews', compact('reviews'));
    // }
}
