<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name',
        'food_photo',
        'calories',
        'nutrition_info',
        'ingredients',
        'bmi_levels',
        'description',
    ];
    
    protected $casts = [
        'nutrition_info' => 'array',
        'ingredients' => 'array',
        'bmi_levels' => 'array',
    ];
    
}
