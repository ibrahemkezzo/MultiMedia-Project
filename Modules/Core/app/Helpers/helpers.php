<?php

// Modules/Core/Helpers/helpers.php
  // استيراد الـ Interface فقط (ليس namespace كامل)

use Modules\Core\Interfaces\UploadInterface;
use Modules\Core\Services\SettingService;

if (!function_exists('upload')) {  // التحقق إذا الدالة غير موجودة (لمنع إعادة تعريف)
    /**
     * Get the UploadService instance.
     *
     * @return UploadInterface
     */
    function upload(): UploadInterface  // تعريف الدالة (بدون param، ترجع UploadInterface)
    {
        return app(UploadInterface::class);  // استخدام Laravel's Container للحصول على الـ Service
    }
}


if (!function_exists('setting')) {
    // الدالة الذكية (الأصلية) للفرق التلقائي
    function setting(string $key, $value = null, ?int $storeId = null, string $type = 'string', string $group = 'general')
    {
        $service = app(SettingService::class);

        if ($value !== null && $storeId !== null) {
            $service->set($key, $value, $storeId, ['type' => $type, 'group' => $group]);
            return;
        }

        return $service->get($key, $value, $storeId);
    }
}

if (!function_exists('setting_get')) {
    // دالة للجلب فقط (ما في حفظ)
    function setting_get(string $key, $fallback = null, ?int $storeId = null)
    {
        return app(SettingService::class)->get($key, $fallback, $storeId);
    }
}

if (!function_exists('setting_set')) {
    // دالة للحفظ فقط (ما في جلب)، مع type/group اختياري
    function setting_set(string $key, $value, ?int $storeId = null, string $type = 'string', string $group = 'general')
    {
        app(SettingService::class)->set($key, $value, $storeId, ['type' => $type, 'group' => $group]);
    }
}
