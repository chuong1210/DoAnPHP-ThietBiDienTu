<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ReplyContactMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách review theo trạng thái
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $reviews = Review::where('status', $status)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(20);

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    /**
     * Hiển thị form thêm đánh giá
     */
    public function create()
    {
        $users = User::all();       // Lấy tất cả người dùng
        $products = Product::all(); // Lấy tất cả sản phẩm

        return view('admin.reviews.create', compact('users', 'products'));
    }

    /**
     * Lưu đánh giá mới
     */
    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'user_name' => 'required|string|max:255', // để tạo user nếu cần
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // === XỬ LÝ USER_ID ===
        // Giả sử cột tên người dùng trong bảng users là 'full_name'
        if (empty($validated['user_id']) && !empty($validated['user_name'])) {
            $user = User::firstOrCreate(
                ['full_name' => $validated['user_name']], // cột thật trong bảng users
                ['email' => $validated['user_name'].'@example.com', 'password' => bcrypt('123456')] // trường bắt buộc khác
            );  
            $validated['user_id'] = $user->id;
        }

        // Thiết lập các trường mặc định
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['status'] = 'pending';

        // === XỬ LÝ UPLOAD ẢNH ===
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images'), $fileName);
            $validated['image'] = $fileName;
        }

        // Tạo đánh giá
        Review::create($validated);

        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Đánh giá đã được thêm thành công!');
    }


    /**
     * Hiển thị form chỉnh sửa đánh giá
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        $users = User::all();
        $products = Product::all();

        return view('admin.reviews.edit', compact('review', 'users', 'products'));
    }

    /**
     * Cập nhật đánh giá
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'user_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ]);

        $review = Review::findOrFail($id);

        // Xử lý user_name → cập nhật user_id nếu tên thay đổi
        if (!empty($validated['user_name'])) {
            $user = User::firstOrCreate(['name' => $validated['user_name']]);
            $validated['user_id'] = $user->id;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'Đánh giá đã được cập nhật!');
    }
public function markAsReplied($id)
{
    $contact = Contact::findOrFail($id);

    // Nội dung reply bạn có thể lấy từ request hoặc mặc định
    $replyMessage = "Cảm ơn bạn đã liên hệ, chúng tôi sẽ xử lý sớm!";

    // Gửi email
    Mail::to($contact->email)->send(new ReplyContactMail($contact, $replyMessage));

    // Cập nhật trạng thái contact
    $contact->status = 'replied';
    $contact->save();

    return redirect()->back()->with('success', 'Đã gửi phản hồi và cập nhật trạng thái!');
}
    /**
     * Xóa đánh giá
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá thành công!');
    }
}
