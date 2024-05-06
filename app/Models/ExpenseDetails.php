<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetails extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'expense_id',
        'expense_head_id',
        'unit_price',
        'quantity',
    ];
    
    public function expense_head()
    {
        return $this->belongsTo(ExpenseHead::class, 'expense_head_id');
    }
}
