<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\HasMedia;
use Modules\Core\Traits\HasSlug;

// use Modules\Core\Database\Factories\BaseModelFactory;

class BaseModel extends Model
{
use HasSlug, HasMedia;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

/**
 * ===================================================================
 * شرح الكلاس: BaseModel
 * ===================================================================
 * الهدف: كلاس أساسي يرث منه كل المودلز في المشروع لتوحيد الميزات
 * لماذا وُجد: لتجنب تكرار Traits في كل Model، وتوفير قاعدة نظيفة
 * المهام الرئيسية:
 *   - يدمج SoftDeletes + HasSlug + HasMedia تلقائياً
 *   - getRouteKeyName(): يجعل الروابط تستخدم slug بدل ID
 *   - protected $guarded: يحمي ID فقط
 * كيفية الاستخدام:
 *   1. في أي Model: class Store extends BaseModel { protected $fillable = [...]; }
 *   2. في Route: Route::model('store', Store::class); // slug يعمل تلقائياً
 *   3. في Query: $store = Store::findBySlug('my-store');
 *   مثال: في Category Module: class Category extends BaseModel { ... } // جاهز للـ slug والصور
 * ===================================================================
 */
