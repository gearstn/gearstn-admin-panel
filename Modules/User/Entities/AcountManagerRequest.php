<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcountManagerRequest extends Model
{
    use HasFactory;

    protected $table = 'account_manager_requests';

    protected $fillable = [
        'request_type',
        'message',
        'read',
        'done',
        'user_id',
    ];

    public static $cast = [
        'request_type' => 'required',
        'message' => 'required',
        'user_id' => 'required',
    ];


    protected static function newFactory()
    {
        // return \Modules\User\Database\factories\AcountManagerRequestFactory::new();
    }
}
