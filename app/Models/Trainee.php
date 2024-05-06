<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'name',
        'department_id',
        'designation_id',
        'joining_date',
        'phone',
        'email',
        'sex',
        'address',
        'status',
        'created_by_id',
        'updated_by_id',
    ];  

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class,'designation_id');
    }
}
