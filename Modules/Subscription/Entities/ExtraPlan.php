<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExtraPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number_of_listing',
        'photos_of_listing',
        'number_of_months',
        'starts_at',
        'ends_at',
        'machines',
        'user_id'
    ];
}
