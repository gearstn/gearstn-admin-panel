<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    protected $fillable = ['receivers','subject','body_en','body_ar','sent_time','scheduled','receiver_type'];
    public static $cast = [
        'receivers' => 'required',
        'subject' => 'required',
        'body_en' => 'required',
        'body_ar' => 'required'
    ];
}
