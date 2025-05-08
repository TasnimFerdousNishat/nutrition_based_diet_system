<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'u_id',
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
}

