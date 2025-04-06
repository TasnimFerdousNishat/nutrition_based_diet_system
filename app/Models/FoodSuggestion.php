<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodSuggestion extends Model
{
    use HasFactory;

    protected $table = 'food_suggestions';

    protected $fillable = [
        'name',
        'ingredients',
        'bmi_levels',
        'meal_time',
        'nutrition_info',
        'photo',
        'description',
    ];
}
