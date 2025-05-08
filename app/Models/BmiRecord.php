<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmiRecord extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'height', 'weight', 'bmi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
