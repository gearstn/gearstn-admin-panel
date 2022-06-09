<?php

namespace Modules\Mail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mail extends Model
{
    use HasFactory;
    protected $fillable = ['receivers','subject','body_en','body_ar','sent_time','scheduled','receiver_type'];
    public static $cast = [
        'receivers' => 'required|array|min:1',
        'subject' => 'required',
        'body_en' => 'required',
        'body_ar' => 'required'
    ];
}
