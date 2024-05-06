<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'schedule_id',
        'evaluation_date',
        'total_marks',
        'created_by_id',
        'updated_by_id',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')->with('batch');
    }
}
