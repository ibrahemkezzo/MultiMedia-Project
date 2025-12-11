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
            $table->string('key');                              // بدون unique هنا
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->boolean('is_translatable')->default(false);
            $table->unsignedBigInteger('store_id')->nullable(); // null = عام، غير null = خاص بالمتجر
            $table->timestamps();

            // الحل: unique مشترك بين key + store_id
            $table->unique(['key', 'store_id'], 'settings_key_store_id_unique');

            // لما يكون store_id = null (إعداد عام)، ما يسمح يكرر الـ key
            $table->unique(['key', 'store_id'], 'settings_key_global_unique')
                  ->whereNull('store_id');

            $table->foreign('store_id')
                  ->references('id')
                  ->on('stores')
                  ->onDelete('cascade');

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
