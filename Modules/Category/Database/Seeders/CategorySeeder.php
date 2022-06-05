<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title_en' => 'construction',
                'title_ar' => 'معدات بناء',
                'image_url' => 'https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/636ac9d7-0472-47a4-b2be-2016adf75ceb1.jpg',
            ],
       ];

       foreach ($categories as $category) {
           Category::create($category);
       }
    }
}
