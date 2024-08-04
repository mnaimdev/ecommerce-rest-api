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
        Schema::create('payment_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('payment_type', ['partial', 'full'])->nullable();
            $table->double('payment_amount')->nullable();
            $table->enum('payment_method', ['cash on delivery', 'online payment', 'cash payment', 'card payment', 'mobile payment', 'bank transfer']);
            $table->string('payment_method_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('transaction_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_information');
    }
};
