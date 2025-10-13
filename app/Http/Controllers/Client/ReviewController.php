<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * Hiển thị form đánh giá sản phẩm (client)
     * GET /products/{slug}/reviews/create
     */
    public function create($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }

        $product = $this->productRepository->getProductBySlug($slug);

        return view('client.reviews.create', compact('product'));
    }

    /**
     * Lưu đánh giá mới (client)
     * POST /products/{slug}/reviews
     */
    public function store(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }

        $product = $this->productRepository->getProductBySlug($slug);

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn điểm đánh giá.',
            'rating.between' => 'Điểm đánh giá phải từ 1 đến 5.',
            'comment.required' => 'Vui lòng nhập nội dung đánh giá.',
            'comment.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ];

            $this->reviewRepository->createReview($data);

            return redirect()->route('client.product.show', $slug)
                ->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Hiển thị danh sách đánh giá của user (client)
     * GET /my-reviews
     */
    public function myReviews()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $reviews = $this->reviewRepository->getReviewsByUser(Auth::id());

        return view('client.reviews.my-reviews', compact('reviews'));
    }
}
