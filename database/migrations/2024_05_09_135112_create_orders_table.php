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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable();
            $table->foreignId('shipping_address_id')->nullable();
            $table->foreignId('coupon_id')->nullable();
            $table->foreignId('pos_branch_id')->nullable();
            $table->foreignId('social_shop_id')->nullable();
            $table->foreignId('delivery_charge_id')->nullable();
            $table->foreignId('order_status_id')->nullable();
            $table->enum('order_type', ['social', 'walking', 'ecommerce']);
            $table->string('invoice_no')->nullable();
            $table->enum('delivery_type', ['own delivery', 'courier service', 'self receive'])->nullable();
            $table->date('delivery_date')->nullable();
            $table->double('subtotal');
            $table->double('delivery_charge')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('discount_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->text('note')->nullable();
            $table->boolean('print_status')->nullable();
            $table->integer('print_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
