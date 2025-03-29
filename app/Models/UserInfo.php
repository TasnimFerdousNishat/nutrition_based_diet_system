<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class UserInfo extends Model
{
    use HasFactory;

    // Explicitly define the table name (optional but recommended)
    protected $table = 'user_infos';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'user_id', 
        'birthday', 
        'gender', 
        'address', 
        'contact', 
        'em_contact', 
        'diabetes', 
        'menstrual_cycle', 
        'description'
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
