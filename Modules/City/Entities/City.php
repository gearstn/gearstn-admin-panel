<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = ['title_en','title_ar','country_id'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
    ];

    protected static function newFactory()
    {
        //return \Modules\City\Database\factories\CityFactory::new();
    }
}
