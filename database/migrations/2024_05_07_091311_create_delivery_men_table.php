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
        Schema::create('delivery_men', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('nid_number')->nullable();
            $table->string('nid_image')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_image')->nullable();
            $table->text('address');
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_name')->nullable();
            $table->text('reference_address')->nullable();
            $table->string('reference_nid')->nullable();
            $table->string('reference_phone')->nullable();
            $table->string('reference_passport_number')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_men');
    }
};
