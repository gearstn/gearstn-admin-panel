<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $fillable = [
        'title_en',
        'title_ar',
        'category_id',
    ];

    public static $cast = [
        'title_en' => 'required|unique:subcategories',
        'title_ar' => 'required',
        'category_id' => 'required',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function manufactures()
    {
        return $this->hasMany(Manufacture::class);
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
