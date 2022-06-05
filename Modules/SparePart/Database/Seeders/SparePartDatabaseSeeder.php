<?php

namespace Modules\SparePart\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\SparePart\Entities\SparePart;
use Modules\SparePartModel\Entities\SparePartModel;
use Modules\SubCategory\Entities\SubCategory;

class SparePartDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_category = SubCategory::where('title_en','Engine')->first();
        $spare_part = [
            'year'=> 2012,
            'sn'=> '111111',
            'description'=> 'test',
            'country'=> 'Egypt',
            'slug'=> 'spare-part-slug',
            'images'=> json_encode([1]),
            'sku'=> '1212112',
            'price'=> 1000,
            'seller_id'=> 1,
            'city_id'=> 1,
            'category_id'=> Category::where('title_en','spare parts')->first()->id,
            'sub_category_id'=> $sub_category->id,
            'manufacture_id'=> 1,
            'model_id'=> SparePartModel::where('title_en','dx-engine')->first()->id,
        ];
        SparePart::create($spare_part);
    }
}
