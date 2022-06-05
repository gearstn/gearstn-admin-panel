<?php

namespace Modules\ServiceType\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ServiceType\Entities\ServiceType;

class ServiceTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceType::create(['title_en' => 'transport' ,'title_ar'=>'شحن']);
        ServiceType::create(['title_en' => 'maintenance' ,'title_ar'=>'صيانة']);
    }
}
