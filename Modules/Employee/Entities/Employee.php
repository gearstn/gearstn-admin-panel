<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'title_en',
        'title_ar',
        'name_en',
        'name_ar',
        'image_url',
        'linkedin_url'
    ];
    public static $cast = [
        'title_en' => 'required',
        'title_ar' => 'required',
        'name_en' => 'required',
        'name_ar' => 'required',
    ];

    protected static function newFactory()
    {
        //return \Modules\Employee\Database\factories\EmployeeFactory::new();
    }
}
