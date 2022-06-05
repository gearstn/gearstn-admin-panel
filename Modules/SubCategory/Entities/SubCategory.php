<?php

namespace Modules\SubCategory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;
use Modules\Machine\Entities\Machine;
use Modules\MachineModel\Entities\MachineModel;
use Modules\Manufacture\Entities\Manufacture;

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
        return $this->belongsToMany(Manufacture::class, 'subcategory_manufacture');
    }
    public function machine_models()
    {
        return $this->hasMany(MachineModel::class);
    }
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
    public function spare_parts()
    {
        return $this->hasMany(SparePart::class);
    }

    protected static function newFactory()
    {
        // return \Modules\SubCategory\Database\factories\SubCategoryFactory::new();
    }
}
