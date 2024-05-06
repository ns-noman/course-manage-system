<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'title',
        'total_duration',
        'per_class_duration',
        'total_class',
        'class_per_week',
        'objective',
        'methodology',
        'benifits',
        'short_syllabus',
        'description',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
