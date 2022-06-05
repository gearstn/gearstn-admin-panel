<?php

namespace Modules\SparePart\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use LamaLama\Wishlist\Wishlistable;
use Modules\SparePartModel\Entities\SparePartModel;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SubCategory\Entities\SubCategory;

class SparePart extends Model implements Viewable
{
    use Searchable;
    use Wishlistable;
    use InteractsWithViews;

    protected $table = 'spare_parts';

    protected $fillable = [
        'description',
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
        'country_id',
        'is_original',
        'condition'
    ];
    public static $cast = [
        // 'year' => 'required',
        // 'country' => 'required',
        // 'sn' => 'required',
        // 'description' => 'required',
        // 'condition' => 'required',
        // 'sell_type' => 'required',
        // 'seller_id' => 'required',
        // 'category_id' => 'required',
        // 'sub_category_id' => 'required',
        // 'manufacture_id' => 'required',
        // 'model_id' => 'required',
        // 'city_id' => 'required',
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
        ];
    }

    protected static function newFactory()
    {
        // return \Modules\SparePart\Database\factories\SparePartFactory::new();
    }
}
