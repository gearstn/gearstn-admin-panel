<?php

namespace Modules\Manufacture\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Machine\Entities\Machine;
use Modules\MachineModel\Entities\MachineModel;
use Modules\SparePart\Entities\SparePart;
use Modules\SubCategory\Entities\SubCategory;

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
    public function spare_parts()
    {
        return $this->hasMany(SparePart::class);
    }

    protected static function newFactory()
    {
        //return \Modules\Manufacture\Database\factories\ManufactureFactory::new();
    }
}
