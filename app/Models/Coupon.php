<?php
// ==========================================
// app/Models/Coupon.php
// ==========================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'max_uses',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    // Helper methods
    public function isValid()
    {
        if (!$this->is_active) return false;
        if ($this->start_date && Carbon::parse($this->start_date)->isFuture()) return false;
        if ($this->end_date && Carbon::parse($this->end_date)->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if ($orderTotal < $this->min_order) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return $this->value;
        } else { // percent
            return ($orderTotal * $this->value) / 100;
        }
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}
