<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');                            // model_type + model_id (لأي مودل: Product, Category...)
            $table->uuid('uuid')->nullable()->unique();
            $table->string('collection_name');                  // avatar, gallery, documents, banner
            $table->string('name');                             // اسم الملف الأصلي (مثل: product-1.jpg)
            $table->string('file_name');                        // اسم الملف المخزن (1a2b3c4d.jpg)
            $table->string('mime_type')->nullable();
            $table->string('disk')->default('public');
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->json('manipulations')->nullable();          // تحويلات الصورة (thumb, large...)
            $table->json('custom_properties')->nullable();
            $table->json('generated_conversions')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();

            // $table->index(['model_type', 'model_id']);
            $table->index('collection_name');
            $table->index('order_column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};


/**
 * ===================================================================
 * شرح الكلاس: Media Migration
 * ===================================================================
 * الهدف: جدول لإدارة الميديا (صور، ملفات) المرتبطة بأي مودل في المشروع
 * لماذا وُجد: بديل خفيف لـ Spatie MediaLibrary في المراحل الأولى (أسرع وأقل تعقيداً)
 * المهام الرئيسية:
 *   - تخزين مسارات الملفات مع دعم collections (مثل gallery للمنتجات)
 *   - دعم conversions (thumb, medium) و UUID للأمان
 *   - حذف تلقائي للملفات عند حذف الـ Media
 * كيفية الاستخدام:
 *   1. في Migration: php artisan migrate
 *   2. في Model: use HasMedia; ثم $model->addMedia($file, 'gallery');
 *   3. استعلام: $product->getMedia('gallery')->first()->getUrl('thumb');
 *   مثال: في Product Module: $product->addMedia($request->file('images'), 'images');
 * ===================================================================
 */
