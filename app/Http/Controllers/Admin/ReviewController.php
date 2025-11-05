<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use App\Models\Contact;
use App\Mail\ReplyContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $reviews = Review::with(['user', 'product'])
            ->when($status, fn($q, $s) => $q->where('status', $s))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    public function create()
    {
        $users = User::select('id', 'name')->whereNotNull('name')->get();
        $products = Product::select('id', 'name')->get();

        return view('admin.reviews.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment'     => 'required|string|max:1000',
            'user_id'     => 'required|exists:users,id', // ← BẮT BUỘC user_id
            'product_id'  => 'required|exists:products,id',
            'rating'      => 'required|integer|min:1|max:5',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'user_id'     => $validated['user_id'],
            'product_id'  => $validated['product_id'],
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'],
            'status'      => 'pending',
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/reviews'), $fileName);
            $data['image'] = $fileName;
        }

        Review::create($data);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Thêm đánh giá thành công!');
    }

    public function edit($id)
    {
        $review = Review::with(['user', 'product'])->findOrFail($id);
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->status = $request->status;
        $review->save();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if ($review->image && file_exists(public_path('uploads/reviews/' . $review->image))) {
            unlink(public_path('uploads/reviews/' . $review->image));
        }

        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Xóa đánh giá thành công!');
    }

    public function markAsReplied($id)
    {
        $contact = Contact::findOrFail($id);
        $replyMessage = "Cảm ơn bạn đã liên hệ! Chúng tôi đã nhận được tin nhắn và sẽ xử lý sớm nhất.";

        Mail::to($contact->email)->send(new ReplyContactMail($contact, $replyMessage));

        $contact->status = 'replied';
        $contact->save();

        return redirect()->back()->with('success', 'Đã gửi phản hồi và cập nhật trạng thái!');
    }
}
