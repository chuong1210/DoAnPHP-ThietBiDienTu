<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'product_catalogue_id',
        'image',
        'icon',
        'album',
        'publish',
        'order',
        'user_id',
        'deleted_at',
        'follow',
        'price',
        'code',
        'made_in',
        'attributeCatalogue',
        'attribute',
        'variant',
        'warranty_time'
    ];

    protected $table = 'products';

    public function languages()
    {
        return $this->belongsToMany('product_language', 'product_id', 'language_id')->withPivot(
            'name',
            'canonical',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description',
            'content'
        )->withTimestamps();;
    }

    public function product_catalogues()
    {
        return $this->belongsToMany('product_catalogue_product', 'product_id', 'product_catalogue_id')->withPivot('product_catalogue_id', 'product_id');
    }

    public function product_variants()
    {
        return $this->hasMany('product_id', 'id');
    }



    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_product_variant', 'product_id', 'promotion_id')->withPivot(
            'variant_uuid',
            'model',
        )->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')->withPivot(
            'variant_uuid',
            'quantity',
            'price',
            'priceOriginal',
            'promotion',
            'option',
        )->withTimestamps();;
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute', 'product_id', 'attribute_id');
    }
}
