<?php

namespace Modules\Core\Interfaces;

use Illuminate\Http\UploadedFile;

interface UploadInterface {
    /**
     * Upload a file to the specified folder and disk.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string $disk
     * @return string The URL of the uploaded file
     */
    public function upload(UploadedFile $file, string $folder = 'uploads', string $disk = 'public'): string;

    /**
     * Upload a file to a model using HasMedia trait.
     *
     * @param UploadedFile $file
     * @param mixed $model
     * @param string $collection
     * @return void
     */
    public function uploadToModel(UploadedFile $file, $model, string $collection = 'default'): void;

    /**
     * Delete a file if it exists by URL.
     *
     * @param string $url
     * @return void
     */
    public function deleteIfExists(string $url): void;

    /**
     * Generate thumbnail or conversions (extendable).
     *
     * @param UploadedFile $file
     * @param string $path
     * @return void
     */
    public function generateThumbnail(UploadedFile $file, string $path): void;
}


/**
 * ===================================================================
 * شرح الكلاس: UploadInterface
 * ===================================================================
 * الهدف: تعريف العقد (Contract) لأي Upload Service في المشروع
 * لماذا وُجد: لتطبيق Dependency Inversion (SOLID)، مما يسمح بتبديل الـ Implementations دون تغيير الكود (مثل Local vs S3)
 * المهام الرئيسية:
 *   - تعريف الدوال الرئيسية للرفع/الحذف/التحويلات
 * كيفية الاستخدام:
 *   1. في Service: class UploadService implements UploadInterface { ... }
 *   2. في Controller: public function __construct(UploadInterface $upload) { $this->upload = $upload; }
 *   3. في Provider: $this->app->singleton(UploadInterface::class, UploadService::class);
 *   مثال: $this->upload->upload($file); // يعمل مع أي implementation
 * ===================================================================
 */
