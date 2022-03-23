<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'machine_id'
    ];

    public static $cast = [
        'chat_token' => 'required|unique:conversations',
        'acquire_id' => 'required',
        'owner_id' => 'required',
        'machine_id' => 'required',
    ];
}
