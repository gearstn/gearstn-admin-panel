<?php

namespace Modules\Manufacture\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Manufacture\Entities\Manufacture;
use Modules\SubCategory\Entities\SubCategory;

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
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => ' john deere',
                'title_ar' => ' جون دييره',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'volvo',
                'title_ar' => 'فولفو',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'kawasaki',
                'title_ar' => 'كاواساكى',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'hitachi',
                'title_ar' => 'هيتاشى',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'komatsu',
                'title_ar' => 'كومتسو',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'case',
                'title_ar' => 'كاس',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'dosan',
                'title_ar' => 'دوسان',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'jcb',
                'title_ar' => 'ج سى بي',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'newholland',
                'title_ar' => 'نيوهولاند',
                'category_id' => Category::all()->random()->id,
            ],
            [
                'title_en' => 'ingresrol rand',
                'title_ar' => 'انجريرول',
                'category_id' => Category::all()->random()->id,
            ],
       ];

       foreach ($manufactures as $manufacture) {
           Manufacture::create($manufacture);
       }
    }
}
