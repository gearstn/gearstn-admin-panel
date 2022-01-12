<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'title_en',
        'title_ar',
        'post_date',
        'image_url',
        'bodytext_en',
        'bodytext_Ar',
        'slug',
    ];
    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'post_date' => 'required',
        'image_url' => 'required',
        'bodytext_en' => 'required',
        'bodytext_ar' => 'required',
    ];
}
