<?php

namespace Modules\City\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\City\Entities\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ["title_ar" => "القاهرة","title_en" => "Cairo"],
            ["title_ar" => "الجيزة","title_en" => "Giza"],
            ["title_ar" => "الأسكندرية","title_en" => "Alexandria"],
            ["title_ar" => "الدقهلية","title_en" => "Dakahlia"],
            ["title_ar" => "البحر الأحمر","title_en" => "Red Sea"],
            ["title_ar" => "البحيرة","title_en" => "Beheira"],
            ["title_ar" => "الفيوم","title_en" => "Fayoum"],
            ["title_ar" => "الغربية","title_en" => "Gharbiya"],
            ["title_ar" => "الإسماعلية","title_en" => "Ismailia"],
            ["title_ar" => "المنوفية","title_en" => "Menofia"],
            ["title_ar" => "المنيا","title_en" => "Minya"],
            ["title_ar" => "القليوبية","title_en" => "Qaliubiya"],
            ["title_ar" => "الوادي الجديد","title_en" => "New Valley"],
            ["title_ar" => "السويس","title_en" => "Suez"],
            ["title_ar" => "اسوان","title_en" => "Aswan"],
            ["title_ar" => "اسيوط","title_en" => "Assiut"],
            ["title_ar" => "بني سويف","title_en" => "Beni Suef"],
            ["title_ar" => "بورسعيد","title_en" => "Port Said"],
            ["title_ar" => "دمياط","title_en" => "Damietta"],
            ["title_ar" => "الشرقية","title_en" => "Sharkia"],
            ["title_ar" => "جنوب سيناء","title_en" => "South Sinai"],
            ["title_ar" => "كفر الشيخ","title_en" => "Kafr Al sheikh"],
            ["title_ar" => "مطروح","title_en" => "Matrouh"],
            ["title_ar" => "الأقصر","title_en" => "Luxor"],
            ["title_ar" => "قنا","title_en" => "Qena"],
            ["title_ar" => "شمال سيناء","title_en" => "North Sinai"],
            ["title_ar" => "سوهاج","title_en" => "Sohag"]
        ];
        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
