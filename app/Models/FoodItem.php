<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodItem extends Model
{
    use HasFactory;

    protected $table = 'food_items';

    protected $fillable = [
        'name',
        'bmi_levels',
        'meal_time',
        'nutrition_info',
        'photo',
        'price',
        'description',
    ];

    protected $casts = [
        'bmi_levels' => 'array',
        'nutrition_info' => 'array',
    ];
}
