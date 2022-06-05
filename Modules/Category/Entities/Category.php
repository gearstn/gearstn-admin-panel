<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Machine\Entities\Machine;
use Modules\MachineModel\Entities\MachineModel;
use Modules\SubCategory\Entities\SubCategory;
use Modules\Manufacture\Entities\Manufacture;

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
    public function spare_parts()
    {
        return $this->hasMany(SparePart::class);
    }

    protected static function newFactory()
    {
        //return \Modules\Category\Database\factories\CategoryFactory::new();
    }
}
