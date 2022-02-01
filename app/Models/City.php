<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    protected $fillable = ['title_en','title_ar'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
    ];

}
