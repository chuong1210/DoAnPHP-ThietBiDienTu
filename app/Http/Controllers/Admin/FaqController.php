<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
   // Hiển thị tất cả các FAQ đang hoạt động
    public function index()
    {
        $faqs = Faq::active()->get();
    $categories = Faq::getCategoryOptions(); // hoặc danh sách động
    return view('admin.faqs.index', compact('faqs', 'categories'));

    }

    // Hiển thị FAQ theo danh mục
    public function showByCategory($category)
    {
        $faqs = Faq::active()->byCategory($category)->get();
        return view('admin.faqs.category', compact('faqs', 'category')); // sửa đường dẫn
    }

    // Form tạo mới FAQ
    public function create()
    {
        // Đảm bảo chỉ trả về mảng chuỗi
        $categories = Faq::getCategoryOptions(); // hoặc tự định nghĩa

        // Nếu getCategoryOptions() trả về mảng key-value, chỉ lấy value
        $categories = is_array($categories) ? array_values($categories) : $categories;

        // Hoặc ép kiểu thành mảng chuỗi
        $categories = collect($categories)->flatten()->unique()->values()->all();

        return view('admin.faqs.create', compact('categories'));
    }
    // Lưu FAQ mới
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faqs.index')->with('success', 'Thêm FAQ thành công');
    }

    // Form chỉnh sửa
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    // Cập nhật FAQ
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faqs.index')->with('success', 'Cập nhật FAQ thành công');
    }

    // Xóa FAQ
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'Xóa FAQ thành công');
    }

    // Xem chi tiết
    public function show(Faq $faq)
    {
        return view('admin.faqs.show', compact('faq'));
    }
}
