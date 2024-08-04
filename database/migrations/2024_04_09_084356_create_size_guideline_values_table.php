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
        Schema::create('size_guideline_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_guideline_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('size_guideline_label_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_guideline_values');
    }
};