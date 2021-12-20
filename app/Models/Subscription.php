<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    protected $fillable = ['title_en','title_ar','details'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'details' => 'required',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
