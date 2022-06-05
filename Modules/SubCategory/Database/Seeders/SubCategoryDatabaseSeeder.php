<?php

namespace Modules\SubCategory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SubCategory\Entities\SubCategory;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
           SubCategory::create($sub_category);
       }
    }
}
