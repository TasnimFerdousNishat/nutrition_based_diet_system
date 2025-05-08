<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FestiveFood extends Model
{
    use HasFactory;

    protected $table = 'festive_foods';

    protected $fillable = [
        'name',
        'festname',
        'bmi_levels',
        'photo',
        'ingredients',
        'description',
    ];

    protected $casts = [
        'bmi_levels' => 'array',
        'ingredients' => 'array',
    ];
}