<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'schedule_id',
        'expense_no',
        'expense_date',
        'total_expense',
        'note',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')->with('batch');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by_id');
    }
}
