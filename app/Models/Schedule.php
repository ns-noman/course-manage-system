<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'batch_id',
        'start_time',
        'end_time',
        'week_days',
        'start_date',
        'end_date',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id')->with(['trainer','course']);
    }
}
