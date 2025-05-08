<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('recipes', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('food_photo')->nullable();
        $table->integer('calories')->nullable();
        $table->json('nutrition_info')->nullable();
        $table->json('ingredients')->nullable();
        $table->json('bmi_levels')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
