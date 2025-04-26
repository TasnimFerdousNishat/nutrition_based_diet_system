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
    Schema::create('festive_foods', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('festname');
        $table->json('bmi_levels')->nullable();
        $table->string('photo');
        $table->json('ingredients')->nullable();
        $table->text('description');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festive_food');
    }
};
