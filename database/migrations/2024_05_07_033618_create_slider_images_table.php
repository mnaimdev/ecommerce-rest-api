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
        Schema::create('slider_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name')->unique();
            $table->enum('redirectional_type', ['ltr', 'rtl', 'btu', 'utb'])->nullable();
            $table->string('title')->nullable();
            $table->string('title_color')->nullable();
            $table->string('title_font_size')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('sub_title_color')->nullable();
            $table->string('sub_title_font_size')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('button_hover_color')->nullable();
            $table->string('text_hover_color')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_images');
    }
};
