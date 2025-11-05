<?php
// ==========================================
// app/Models/Review.php
// ==========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
        // app/Models/Review.php
    protected $fillable = [
        'comment',
        'user_id',     // ← Chỉ cần user_id
        'product_id',
        'rating',
        'status',      // ← Giữ lại
        // 'user_name' → XÓA DÒNG NÀY
    ];


    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helper methods
    public function isApproved()
    {
        return $this->status === 'approved';
    }
}
