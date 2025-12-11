<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\BaseModel;

// use Modules\Category\Database\Factories\CategoryFactory;

class Category extends BaseModel
{

    protected $fillable = [
        'name', 'description', 'image', 'icon',
        'parent_id', 'is_active', 'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $slug_source = 'name';

    // علاقات
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    // Scopes
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

/**
 * ===================================================================
 * شرح الكلاس: Category Model
 * ===================================================================
 * الهدف: تمثيل قسم (مع دعم sub-categories عبر parent_id)
 * مميزات:
 *   - HasSlug للـ slug التلقائي
 *   - HasMedia للـ image
 *   - علاقات parent/children
 * كيفية الاستخدام:
 *   Category::main()->active()->get();
 * ===================================================================
 */
