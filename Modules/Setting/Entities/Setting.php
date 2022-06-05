<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'type',
        'value',
    ];
    public static $cast = [
        'type' => 'required|unique:settings',
        'value' => 'required',
    ];
        
    protected static function newFactory()
    {
        // return \Modules\Setting\Database\factories\SettingFactory::new();
    }
}
