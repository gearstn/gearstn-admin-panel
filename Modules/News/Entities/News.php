<?php

namespace Modules\News\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'author_en',
        'author_ar',
        'seo_title_en',
        'seo_title_ar',
        'seo_description_en',
        'seo_description_ar',
    ];
    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'post_date' => 'required',
        'image_id' => 'required',
        'bodytext_en' => 'required',
        'bodytext_ar' => 'required',
        'slug' => 'string',
        'mins_read' => 'integer',
        'author_en' => 'string',
        'author_ar' => 'string',
        'seo_title_en' => 'string',
        'seo_title_ar' => 'string',
        'seo_description_en' => 'string',
        'seo_description_ar' => 'string',
    ];
        
    protected static function newFactory()
    {
        //return \Modules\News\Database\factories\NewsFactory::new();
    }
}
