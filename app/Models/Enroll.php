<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;
    protected $table = 'enrolles';
    protected $fillable = 
    [
        'schedule_id',
        'trainee_id',
        'certificate_no',
        'enroll_date',
        'note',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')->with('batch');
    }
    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id');
    }
}
