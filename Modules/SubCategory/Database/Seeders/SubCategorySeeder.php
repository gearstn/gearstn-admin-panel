<?php

namespace Modules\SubCategory\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\SubCategory\Entities\SubCategory;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */







    public function run()
    {
    //     $sub_categories = [
    //         [
    //             'title_en' => 'wheel loaders',
    //             'title_ar' => 'رافعات شوكية',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'excavators',
    //             'title_ar' => 'حفارات',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'backhoe loader',
    //             'title_ar' => 'لودر حفار',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'motor grader',
    //             'title_ar' => 'ممهدة الطرق',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'roller',
    //             'title_ar' => 'أسطوانة',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'wheel excavators',
    //             'title_ar' => 'حفارات ذات عجلات',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'crawlaer loaders',
    //             'title_ar' => 'لوادر زحافة',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'skid steere',
    //             'title_ar' => 'انزلاقية التوجيه',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //         [
    //             'title_en' => 'dozer',
    //             'title_ar' => 'الجرار',
    //             'category_id' => Category::all()->random()->id,
    //         ],
    //    ];

    //    foreach ($sub_categories as $sub_category) {
    //        SubCategory::create($sub_category);
    //    }

            $sub_categories = [
            [
                'title_en' => 'tailpipe elbow',
                'title_ar' => 'كوعه شكمان',
                'category_id' => 2,
            ],
            [
                'title_en' => 'air filter',
                'title_ar' => 'فلتر الهواء',
                'category_id' => 2,
            ],
            [
                'title_en' => 'Trubo',
                'title_ar' => 'تربو',
                'category_id' => 2,
            ],
            [
                'title_en' => 'cylinder gear',
                'title_ar' => 'اسطوانه فتيس',
                'category_id' => 2,
            ]
       ];

       foreach ($sub_categories as $sub_category) {
           $result[] = SubCategory::create($sub_category);
       }

    }
}
