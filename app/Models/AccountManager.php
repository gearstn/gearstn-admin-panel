<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountManager extends Model
{
    use HasFactory;
    protected $table = 'account_manager_requests';

    protected $fillable = [
        'company_name',
        'email',
        'first_name',
        'last_name',
        'reason',
        'user_id',
        'assigned_to_id'
    ];

    public static $cast = [
        'email' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'user_id' => 'required',
    ];
}
