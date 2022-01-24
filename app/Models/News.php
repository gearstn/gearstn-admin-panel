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
        'image_id',
        'bodytext_en',
        'bodytext_ar',
        'slug',
        'mins_read',
        'author',
        'seo_title',
        'seo_description',
    ];
    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'post_date' => 'required',
        'image_id' => 'required',
        'bodytext_en' => 'required',
        'bodytext_ar' => 'required',
        'author' => 'string',
        'mins_read' => 'integer',
        'seo_title' => 'string',
        'seo_description' => 'string',
    ];
}
