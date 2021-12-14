<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use LamaLama\Wishlist\Wishlistable;

class Machine extends Model
{
    use HasFactory;
    use Searchable;
    use Wishlistable;
    protected $table = 'machines';
    protected $fillable = [
        'year',
        'sn',
        'condition',
        'hours',
        'description',
        'sell_type',
        'rent_hours',
        'country',
        'city',
        'slug',
        'images',
        'approved',
        'featured',
        'verified',
        'sku',
        'price',
        'seller_id',
        'city_id',
        'category_id',
        'sub_category_id',
        'manufacture_id',
        'model_id',
    ];
    public static $cast = [
        'year' => 'required',
        'country' => 'required',
        'sn' => 'required',
        // 'rent_hours' => 'required',
        'description' => 'required',
        'condition' => 'required',
        'sell_type' => 'required',
        'seller_id' => 'required',
        'category_id' => 'required',
        'sub_category_id' => 'required',
        'manufacture_id' => 'required',
        'model_id' => 'required',
        'city_id' => 'required',
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

    public function model()
    {
        return $this->belongsTo(MachineModel::class);
    }

    //User how want to sell a machine
    public function seller()
    {
        return $this->belongsTo(User::class);
    }

        /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'sn' => $this->sn,
            'category_title_en' => $this->category['title_en'],
            'category_title_ar' => $this->category['title_ar'],
            'sub_category_title_en' => $this->sub_category['title_en'],
            'sub_category_title_ar' => $this->sub_category['title_ar'],
            'manufacture_title_en' => $this->manufacture['title_en'],
            'manufacture_title_ar' => $this->manufacture['title_ar'],
            'model_title_en' => $this->model['title_en'],
            'model_title_ar' => $this->model['title_ar']
        ];
    }

}
