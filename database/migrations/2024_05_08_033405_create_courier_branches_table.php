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
        Schema::create('courier_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('branch_name')->unique();
            $table->string('branch_location');
            $table->string('branch_latitude')->nullable();
            $table->string('branch_longitude')->nullable();
            $table->string('merchant_account_no')->nullable();
            $table->string('contact_person_one_name')->nullable();
            $table->string('contact_person_one_phone')->nullable();
            $table->string('contact_person_two_name')->nullable();
            $table->string('contact_person_two_phone')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_branches');
    }
};
