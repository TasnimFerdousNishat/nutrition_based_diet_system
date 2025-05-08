<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('bmi_levels');
            $table->string('excercise_time'); // e.g., "Morning" or "Evening"
            $table->json('excercise_outcome')->nullable(); // Multiple outcomes
            $table->string('photo')->nullable(); // Stored file path
            $table->time('duration'); // Time format: HH:MM:SS
            $table->text('description');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
