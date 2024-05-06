<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationDetails extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'evaluation_id',
        'enroll_id',
        'obtain_marks',
        'remarks',
    ];
}
