<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // 🔹 Danh sách nhóm FAQ hợp lệ (category => [Tên tiếng Việt, Icon])
    public const GROUPS = [
        'order'    => ['Đặt hàng', 'fas fa-shopping-bag'],
        'payment'  => ['Thanh toán', 'fas fa-credit-card'],
        'shipping' => ['Giao hàng', 'fas fa-truck'],
        'warranty' => ['Bảo hành', 'fas fa-shield-alt'],
        'return'   => ['Đổi trả', 'fas fa-sync-alt'],
    ];

    // 🔹 Chỉ lấy các FAQ đang kích hoạt
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // 🔹 Lọc theo category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // 🔹 Lấy tên tiếng Việt của category
    public function getCategoryLabelAttribute()
    {
        return self::GROUPS[$this->category][0] ?? 'Khác';
    }

    // 🔹 Lấy icon tương ứng của category
    public function getCategoryIconAttribute()
    {
        return self::GROUPS[$this->category][1] ?? 'fas fa-question-circle';
    }

    // 🔹 Kiểm tra category có hợp lệ không
    public static function isValidCategory($category)
    {
        return array_key_exists($category, self::GROUPS);
    }

    // 🔹 Lấy danh sách category để hiển thị trong form (option select)
    public static function getCategoryOptions()
    {
        return self::GROUPS;
    }
}
