<?php

namespace Modules\Core\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Core\Interfaces\UploadInterface;

class UploadService implements UploadInterface
{
    public function upload(UploadedFile $file, string $folder = 'uploads', string $disk = null): string
    {
        $disk = $disk ?: config('core.settings_disk', 'public');
        $path = $file->store($folder, $disk);
        return Storage::disk($disk)->url($path);
    }

    public function uploadToModel(UploadedFile $file, $model, string $collection = 'default'): void
    {
        if (!method_exists($model, 'addMedia')) {
            throw new \Exception('Model must use HasMedia trait');
        }
        $model->addMedia($file, $collection);
    }

    public function deleteIfExists(string $url): void
    {
        if (blank($url)) return;

        $path = str_replace('/storage/', '', parse_url($url, PHP_URL_PATH));
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function generateThumbnail(UploadedFile $file, string $path): void
    {
        // استخدم Intervention Image لاحقاً (أضف البكج إذا لزم الأمر)
        // Image::make($file)->fit(300, 300)->save($path . '-thumb.jpg');
    }
}
