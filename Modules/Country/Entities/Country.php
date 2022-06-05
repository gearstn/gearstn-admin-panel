<?php

namespace Modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $fillable = ['title_en','title_ar','code','flag' ,'phone_prefixes'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'code' =>'sometimes'
    ];
    protected static function newFactory()
    {
        // return \Modules\Country\Database\factories\CountryFactory::new();
    }
}
