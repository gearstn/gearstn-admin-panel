<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
