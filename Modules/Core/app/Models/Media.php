<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// use Modules\Core\Database\Factories\MediaFactory;

class Media extends Model
{
    use HasFactory;
protected $fillable = [
        'model_type', 'model_id', 'uuid', 'collection_name', 'name',
        'file_name', 'mime_type', 'disk', 'size', 'custom_properties', 'order_column'
    ];

    protected $casts = [
        'manipulations' => 'array',
        'custom_properties' => 'array',
        'generated_conversions' => 'array',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function getUrl(string $conversion = ''): string
    {
        $path = $conversion ? "conversions/{$this->file_name}-{$conversion}.jpg" : $this->file_name;
        return Storage::disk($this->disk)->url($path);
    }

    public function delete(): ?bool
    {
        // حذف الملف الأصلي والتحويلات
        Storage::disk($this->disk)->delete([$this->file_name]);
        Storage::disk($this->disk)->deleteDirectory("conversions/{$this->file_name}-*");
        return parent::delete();
    }
}


/**
 * ===================================================================
 * شرح الكلاس: Media Model
 * ===================================================================
 * الهدف: إدارة ملف واحد مرفوع (صورة، PDF...) مرتبط بأي مودل
 * لماذا وُجد: لتوفير واجهة سهلة للحصول على روابط الملفات وحذفها
 * المهام الرئيسية:
 *   - getUrl() للحصول على رابط (مع/بدون conversion مثل thumb)
 *   - delete() يحذف الملف الفعلي من الديسك
 *   - علاقة morphTo مع أي مودل
 * كيفية الاستخدام:
 *   1. إنشاء: $media = new Media([...]); $media->save();
 *   2. في Blade: <img src="{{ $media->getUrl('thumb') }}">
 *   3. حذف: $media->delete(); // يحذف من DB + Storage
 *   مثال: في Product: foreach($product->media as $media) { echo $media->getUrl(); }
 * ===================================================================
 */
