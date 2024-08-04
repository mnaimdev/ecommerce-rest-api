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
        Schema::create('slider_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('animation_type', ['slide', 'fade', 'parallax', 'distortion']);
            $table->string('height_on_tablet')->nullable();
            $table->boolean('enable_autoplay')->default(0);
            $table->string('autoplay_speed')->nullable();
            $table->enum('text_position', ['left', 'center', 'right']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_settings');
    }
};
