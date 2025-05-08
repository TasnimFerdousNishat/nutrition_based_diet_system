<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{

    protected $table = "exercises";
    protected $fillable = [
        'name', 'bmi_levels', 'excercise_time',
        'excercise_outcome', 'photo', 'duration', 'description'
    ];

    protected $casts = [
        'bmi_levels' => 'array',
        'excercise_outcome' => 'array',
    ];
}
