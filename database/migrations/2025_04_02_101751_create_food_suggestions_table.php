<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodSuggestionsTable extends Migration
{
    public function up()
    {
        Schema::create('food_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('ingredients');
            $table->json('bmi_levels');
            $table->string('meal_time');
            $table->json('nutrition_info');
            $table->string('photo');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_suggestions');
    }
}
