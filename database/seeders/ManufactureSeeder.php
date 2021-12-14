<?php

namespace Database\Seeders;

use App\Models\Manufacture;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class ManufactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manufactures = [
            [
                'title_en' => 'caterpillar',
                'title_ar' => 'كاتربيلر',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => ' john deere',
                'title_ar' => ' جون دييره',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'volvo',
                'title_ar' => 'فولفو',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'kawasaki',
                'title_ar' => 'كاواساكى',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'hitachi',
                'title_ar' => 'هيتاشى',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'komatsu',
                'title_ar' => 'كومتسو',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'case',
                'title_ar' => 'كاس',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'dosan',
                'title_ar' => 'دوسان',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'jcb',
                'title_ar' => 'ج سى بي',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'newholland',
                'title_ar' => 'نيوهولاند',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
            [
                'title_en' => 'ingresrol rand',
                'title_ar' => 'انجريرول',
                'sub_category_id' => SubCategory::all()->random()->id,
            ],
       ];

       foreach ($manufactures as $manufacture) {
           Manufacture::create($manufacture);
       }
    }
}
