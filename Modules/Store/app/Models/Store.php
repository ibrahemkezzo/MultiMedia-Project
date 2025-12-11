<?php

namespace Modules\Store\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Models\Category;
use Modules\Core\Models\BaseModel;
use Modules\Core\Services\SettingService;

// use Modules\Store\Database\Factories\StoreFactory;

class Store extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'slug', 'status',
        'balance', 'total_sales', 'rating', 'verified_at'
    ];

    protected $slug_source = 'slug'; // جلب الاسم من settings

    protected $casts = [
        'balance' => 'float',
        'total_sales' => 'float',
        'rating' => 'integer',
    ];

    // علاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function settings()
    {
        return $this->hasMany(\Modules\Core\Models\Setting::class, 'store_id');
    }

// جلب الاسم من settings
    public function getNameAttribute()
    {
        return setting_get('store_name', 'متجر بدون اسم', $this->id);
    }

    // جلب إعدادات المتجر كاملة
    public function getSettingsAttribute()
    {
        return app(SettingService::class)->all($this->id);
    }

    // جلب عنوان المتجر من settings
    public function getAddressAttribute()
    {
        return setting_get('store_address', null, $this->id);
    }

    // جلب المدينة
    public function getCityAttribute()
    {
        return setting_get('store_city', null, $this->id);
    }

    // جلب البلد
    public function getCountryAttribute()
    {
        return setting_get('store_country', null, $this->id);
    }

    // جلب الهاتف
    public function getPhoneAttribute()
    {
        return setting_get('store_phone', null, $this->id);
    }

    // جلب البريد
    public function getEmailAttribute()
    {
        return setting_get('store_email', null, $this->id);
    }

    // جلب الوصف
    public function getBioAttribute()
    {
        return setting_get('store_bio', null, $this->id);
    }
    public function getLogoAttribute()
    {
        return setting_get('store_logo', null, $this->id);
    }

    // scope للمتاجر النشطة
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}


/**
 * ===================================================================
 * شرح الكلاس: Store Model
 * ===================================================================
 * الهدف: تمثيل المتجر
 * لماذا وُجد: للتعامل مع بيانات المتاجر
 * المهام الرئيسية:
 *   - HasSlug للـ slug
 *   - علاقات مع User و Category
 *   - جلب الاسم و الإعدادات من settings
 * كيفية الاستخدام:
 *   1. $store->name → جلب من settings
 *   2. $store->settings → كل إعدادات المتجر
 * ===================================================================
 */
