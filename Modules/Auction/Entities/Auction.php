<?php

namespace Modules\Auction\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;

    protected $table = 'auctions';
    protected $fillable = ['title_en','title_ar', 'start_date', 'end_date','country'];

    public static $cast = [
        'title_en' => 'required|unique:auctions',
        'title_ar' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'country' => 'required',
    ];
    
    protected static function newFactory()
    {
        // return \Modules\Auction\Database\factories\AuctionFactory::new();
    }
}
