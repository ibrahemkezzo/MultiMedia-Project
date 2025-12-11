<?php

namespace Modules\Core\Services;

use Illuminate\Http\UploadedFile;

class WebsiteSettingsService
{


    public function all(?int $storeId = null): array
    {
        return app(SettingService::class)->all($storeId);
    }

    public function updateFromArray(array $data, ?int $storeId = null): void
    {
        $fileKeys = ['logo', 'favicon', 'default_store_banner'];

        foreach ($fileKeys as $key) {
            if (array_key_exists($key, $data)) {

                if ($data[$key] instanceof UploadedFile) {
                    $url = upload()->upload($data[$key], 'settings', config('core.settings_disk', 'public'));
                    setting_set($key, $url, $storeId, 'string', 'appearance');
                    unset($data[$key]);
                    continue;
                }

                if ($data[$key] === null) {
                    setting_set($key, null, $storeId, 'string', 'appearance');
                    unset($data[$key]);
                    continue;
                }
            }
        }

        foreach ($data as $key => $value) {
            $type = is_bool($value) ? 'boolean' : (is_numeric($value) ? 'number' : 'string');
            setting_set($key, $value, $storeId, $type, $this->detectGroup($key));
        }
    }

    private function detectGroup(string $key): string
    {
        return match (true) {
            str_contains($key, 'seo') => 'seo',
            str_contains($key, 'stripe') => 'payment',
            str_contains($key, 'smtp') => 'mail',
            str_contains($key, 'logo') || str_contains($key, 'favicon') => 'appearance',
            default => 'general',
        };
    }
}
