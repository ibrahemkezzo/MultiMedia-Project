<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Collection;
use Modules\Core\Models\Media;

trait HasMedia {
    public function media(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function getMedia(string $collection = 'default'): Collection
    {
        return $this->media()->where('collection_name', $collection)->orderBy('order_column')->get();
    }

    public function addMedia($file, string $collection = 'default'): Media
    {
        $path = $file->store('media', 'public');
        $media = $this->media()->create([
            'collection_name' => $collection,
            'name' => $file->getClientOriginalName(),
            'file_name' => basename($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
        ]);

        return $media;
    }

    public function clearMediaCollection(string $collection): void
    {
        $this->getMedia($collection)->each->delete();
    }
}

/**
 * ===================================================================
 * شرح الكلاس: HasMedia Trait
 * ===================================================================
 * الهدف: إضافة دعم رفع وإدارة الميديا (صور/ملفات) لأي مودل بسهولة
 * لماذا وُجد: لتوحيد عملية رفع الصور في كل المشروع (بدل تكرار الكود)
 * المهام الرئيسية:
 *   - media(): علاقة MorphMany مع جدول media
 *   - addMedia(): رفع ملف وإضافته لـ collection
 *   - getMedia(): جلب كل الميديا في collection مع ترتيب
 *   - clearMediaCollection(): حذف كل الميديا في collection
 * كيفية الاستخدام:
 *   1. في Model: class Product extends BaseModel { use HasMedia; }
 *   2. رفع: $product->addMedia($request->file('image'), 'avatar');
 *   3. عرض: @foreach($product->getMedia('gallery') as $media) <img src="{{ $media->getUrl() }}"> @endforeach
 *   مثال: في Form Request: $store->addMedia($file, 'logo'); $store->clearMediaCollection('old-logos');
 * ===================================================================
 */
