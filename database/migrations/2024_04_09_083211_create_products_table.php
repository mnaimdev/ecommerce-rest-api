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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('tax_id')->nullable();
            $table->foreignId('flash_sale_id')->nullable();
            $table->foreignId('size_guideline_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->integer('stock')->nullable();
            $table->string('stock_status')->nullable();
            $table->string('sku');
            $table->string('thumbnail_image')->nullable();
            $table->double('regular_price')->nullable();
            $table->double('sale_price')->nullable();
            $table->double('cost_of_goods')->nullable();
            $table->double('discount')->nullable();
            $table->date('discount_from_date')->nullable();
            $table->date('discount_to_date')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_featured_product')->default(0);
            $table->boolean('is_single_product')->nullable();
            $table->string('status');
            $table->integer('vat')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
