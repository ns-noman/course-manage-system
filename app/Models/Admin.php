<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;

class Admin extends Authenticate
{
    use HasFactory;
    protected $guard = 'admin';
    protected $fillable = 
    [
        'name',
        'type',
        'mobile',
        'email',
        'password',
        'image',
        'status',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'type');
    }
}       
