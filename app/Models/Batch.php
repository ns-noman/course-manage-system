<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'course_id',
        'trainer_id',
        'title',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function trainer()
    {
        return $this->belongsTo(Trainer::class,'trainer_id');
    }
}