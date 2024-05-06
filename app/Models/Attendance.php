<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'schedule_id',
        'enrolle_id',
        'date',
        'attendance_status',
        'comment',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')->with('batch');
    }
    
    public function enroll()
    {
        return $this->belongsTo(Enroll::class, 'enrolle_id')->with('trainee');
    }
}
