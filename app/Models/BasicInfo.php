<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class BasicInfo extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['title', 'moto','address'];
    protected $fillable = 
    [
        'title',
        'moto',
        'phone1',
        'phone2',
        'email',
        'address',
        'logo',
        'favIcon',
        'currency_code',
        'currency_symbol',
        'acceptPaymentType',
        'copyRightName',
        'copyRightLink',
        'mapLink',
        'facebook',
        'instagram',
        'twitter',
        'pinterest',
        'linkedIn',
    ];
}
