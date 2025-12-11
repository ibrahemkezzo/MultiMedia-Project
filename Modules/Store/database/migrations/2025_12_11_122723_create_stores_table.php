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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // صاحب المتجر
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict'); // التخصص (قسم رئيسي)
            $table->string('slug')->unique();
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('pending');
            $table->decimal('balance', 14, 2)->default(0.00);
            $table->decimal('total_sales', 14, 2)->default(0.00);
            $table->unsignedTinyInteger('rating')->default(0);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'category_id','slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};


/**
 * ===================================================================
 * شرح الكلاس: Store Migration
 * ===================================================================
 * الهدف: إنشاء جدول المتاجر
 * لماذا وُجد: لتخزين بيانات المتاجر (مع علاقة بـ User و Category)
 * المهام الرئيسية:
 *   - foreign keys للـ user و category
 *   - status enum للحالة
 *   - balance و total_sales للـ financial
 * كيفية الاستخدام:
 *   1. php artisan module:migrate Store
 *   2. الإعدادات الخاصة (name, logo...) في settings
 * ===================================================================
 */
