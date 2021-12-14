<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['title_en','title_ar','image_url'];

    public static $cast = [
        'title_en' => 'required|unique:categories',
        'title_ar' => 'required',
    ];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }
    public function machine_models()
    {
        return $this->hasMany(MachineModel::class);
    }
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

}
