<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Thêm dòng này

class UserController extends Controller
{
    /**
     * 📋 Hiển thị danh sách người dùng
     */
    public function index(Request $request)
    {
        $query = User::query();

        // 🔍 Tìm kiếm theo tên hoặc email
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 📊 Phân trang
        $users = $query->orderByDesc('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * 🧾 Hiển thị form chỉnh sửa người dùng
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 💾 Cập nhật thông tin người dùng (ngoại trừ email & password)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive',
            'role' => 'required|in:admin,user',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên người dùng.',
            'status.required' => 'Trạng thái không hợp lệ.',
            'role.required' => 'Vui lòng chọn quyền người dùng.',
        ]);

        // 🚫 Không cho phép hạ quyền hoặc sửa thông tin admin chính
        if ($user->role === 'admin' && Auth::id() !== $user->id) {
            if ($request->role !== 'admin') {
                return back()->with('error', 'Không thể thay đổi quyền của tài khoản Admin.');
            }
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    /**
     * ❌ Xóa người dùng (không được xóa admin)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Không thể xóa tài khoản Admin.');
        }

        $user->delete();

        return back()->with('success', 'Xóa người dùng thành công!');
    }
}
