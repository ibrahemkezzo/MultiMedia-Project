<?php

namespace Modules\Core\Services;

use Modules\Core\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
public function get(string $key, $default = null, ?int $storeId = null)
    {
        $cacheKey = "settings.".($storeId ?? 'website').".{$key}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($key, $default, $storeId) {
            $query = Setting::where('key', $key);

            if ($storeId) {
                return $query->where('store_id', $storeId)->first()?->value
                    ?? $query->whereNull('store_id')->first()?->value
                    ?? $default;
            }

            return $query->whereNull('store_id')->first()?->value ?? $default;
        });
    }

    public function set(string $key, $value, ?int $storeId = null, array $extra = []): void
    {
        Setting::updateOrCreate(
            ['key' => $key, 'store_id' => $storeId],
            array_merge(['value' => $value], $extra)
        );

        Cache::forget("settings.".($storeId ?? 'website').".{$key}");
        Cache::forget("settings.".($storeId ?? 'website').".all");
    }

    public function all(?int $storeId = null): array
    {
        return Cache::remember("settings.".($storeId ?? 'website').".all", now()->addHours(24), function () use ($storeId) {
            $query = Setting::general();
            if ($storeId) {
                $query->union(Setting::forStore($storeId));
            }
            return $query->pluck('value', 'key')->toArray();
        });
    }

}


/**
 * ===================================================================
 * شرح الكلاس: SettingService
 * ===================================================================
 * الهدف: الواجهة الوحيدة للوصول/التعديل على الإعدادات مع Cache مدمج
 * لماذا وُجد: لفصل الـ Logic عن الـ Model، وتسريع الاستعلامات بـ Cache
 * المهام الرئيسية:
 *   - get(): جلب إعداد مع fallback (عام إذا لم يوجد خاص بالمتجر)
 *   - set(): حفظ مع Cache flush
 *   - all(): جلب كل الإعدادات كـ array
 * كيفية الاستخدام:
 *   1. في Controller: app(SettingService::class)->get('site_name', 'Default');
 *   2. في Blade: {{ setting('commission_rate', 15, $store->id) }} // Helper function
 *   3. حفظ: setting()->set('logo', $path, $store->id);
 *   مثال: في Admin Controller: $settings = setting()->all(); // مع Cache 24h
 * ===================================================================
 */
