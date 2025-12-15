<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Modules\Core\Models\BaseModel;
use Modules\Store\Models\Store;

// use Modules\Product\Database\Factories\ProductFactory;

class Product extends BaseModel
{
    use HasFactory , SoftDeletes;

  protected $fillable = [
        'store_id', 'category_id', 'name', 'slug',
        'short_description', 'description', 'price', 'compare_price',
        'sku', 'stock', 'weight', 'dimensions', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'price' => 'float',
        'compare_price' => 'float',
        'stock' => 'integer',
        'weight' => 'float',
        'dimensions' => 'array',
        'is_active' => 'boolean',
    ];

    protected $slug_source = 'name';

    // علاقات
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // صور المنتج (gallery collection)
    public function images()
    {
        return $this->getMedia('gallery');
    }

    // scope للمنتجات النشطة
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // scope للمنتجات في المخزون
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
