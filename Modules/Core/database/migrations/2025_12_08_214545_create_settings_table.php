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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();                    // ex: site_name, commission_rate, maintenance_mode
            $table->text('value')->nullable();                  // القيمة (string, json, boolean...)
            $table->string('type')->default('string');         // string|boolean|number|json|image|file
            $table->string('group')->default('general');        // general|seo|payment|store|appearance
            $table->text('description')->nullable();            // للعرض في لوحة التحكم
            $table->boolean('is_translatable')->default(false);
            $table->unsignedBigInteger('store_id')->nullable(); // null = إعداد عام، غير null = خاص بالمتجر
            $table->timestamps();

            // $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->index(['store_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
