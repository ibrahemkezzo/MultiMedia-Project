<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Str;

trait HasSlug {
    public static function bootHasSlug(): void
    {
        static::creating(fn($model) => $model->generateUniqueSlug());
        static::updating(function ($model) {
            if ($model->isDirty($model->slugSourceColumn())) {
                $model->generateUniqueSlug();
            }
        });
    }

    protected function slugSourceColumn(): string
    {
        return $this->slug_source ?? 'name';
    }

    public function generateUniqueSlug(): void
    {
        $source = $this->{$this->slugSourceColumn()} ?? 'item';
        $base = Str::slug($source);
        $slug = $base;
        $count = 1;

        $query = static::where('slug', $slug)->where('id', '!=', $this->id ?? 0);

        if (isset($this->store_id) && $this->store_id) {
            $query->where('store_id', $this->store_id);
        }

        while ($query->exists()) {
            $slug = "{$base}-" . $count++;
        }

        $this->slug = $slug;
    }
}


/**
 * ===================================================================
 * شرح الكلاس: HasSlug Trait
 * ===================================================================
 * الهدف: إضافة ميزة توليد slug فريد تلقائياً للروابط الودية (SEO-friendly)
 * لماذا وُجد: لتجنب استخدام ID في الروابط، ودعم فريد داخل كل متجر
 * المهام الرئيسية:
 *   - boot: يولد slug عند الإنشاء/التحديث
 *   - generateUniqueSlug: يضمن عدم التكرار (مع عداد مثل name-2)
 * كيفية الاستخدام:
 *   1. في Model: class Category extends BaseModel { use HasSlug; protected $slug_source = 'name'; }
 *   2. في Route: Route::get('/category/{category}', ...); // يستخدم slug تلقائياً
 *   3. في Controller: $category = Category::where('slug', $slug)->first();
 *   مثال: $category->name = 'الأجهزة الإلكترونية'; // يولد slug: alajhizat-alelektronia
 * ===================================================================
 */
