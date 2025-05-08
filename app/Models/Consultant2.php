<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant2 extends Model
{
    use HasFactory;

    protected $table = 'consultants_2';

    protected $fillable = [
        'user_id',
        'name',
        'nid',
        'address',
        'contact',
        'em_contact',
        'birthday',
        'gender',
        'license_photo',
        'cv',
        'description',
        'approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
