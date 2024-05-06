<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'id',
        'name',
        'created_by_id',
        'updated_by_id',
        'status'
    ];
}

