<?php

namespace Modules\Upload\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upload extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        // return \Modules\Upload\Database\factories\UploadFactory::new();
    }
}
