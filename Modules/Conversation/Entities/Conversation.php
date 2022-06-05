<?php

namespace Modules\Conversation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';
    protected $fillable = [
        'chat_token',
        'acquire_done',
        'owner_done',
        'acquire_id',
        'owner_id',
        'model_id',
        'model_type'
    ];

    public static $cast = [
        'chat_token' => 'required|unique:conversations',
        'acquire_id' => 'required',
        'owner_id' => 'required',
        'machine_id' => 'required',
    ];
    protected static function newFactory()
    {
        // return \Modules\Conversation\Database\factories\ConversationFactory::new();
    }
}
