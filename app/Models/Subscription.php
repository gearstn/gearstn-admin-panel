<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Subscription extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'subscriptions';
    protected $fillable = ['title_en','title_ar','details','role_id'];

    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'details' => 'required',
        'role_id' => 'required'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
