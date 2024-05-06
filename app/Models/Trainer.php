<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'name',
        'phone',
        'email',
        'sex',
        'address',
        'education',
        'work_experience',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
