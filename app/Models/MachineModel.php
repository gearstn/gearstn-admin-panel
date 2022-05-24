<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineModel extends Model
{

    use HasFactory;
    protected $table = 'machine_models';
    protected $fillable = [
        'title_en',
        'title_ar',
        'category_id',
        'sub_category_id',
        'manufacture_id',
    ];

    public static $cast = [
        'title_en' => 'required|unique:machine_models',
        'title_ar' => 'required',
        'category_id' => 'required',
        'sub_category_id' => 'required',
        'manufacture_id' => 'required',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
