<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;
    protected $table = 'manufactures';
    protected $fillable = [
        'title_en',
        'title_ar',
        'category_id',
    ];

    public static $cast = [
        'title_en' => 'required|unique:manufactures',
        'title_ar' => 'required',
        'category_id' => 'required',
    ];

    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class, 'subcategory_manufacture');

    }
    public function category()
    {
        return $this->belongsTo(Category::class);

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
