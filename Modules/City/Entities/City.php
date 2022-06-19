<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class City extends Model implements Searchable
{
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = ['title_en','title_ar','country_id'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
    ];

    public function getSearchResult(): SearchResult
    {

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title_en,
           $this->title_ar,
        );
    }

    protected static function newFactory()
    {
        //return \Modules\City\Database\factories\CityFactory::new();
    }
}
