<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Category\Database\Seeders\CategorySeeder;
use Modules\City\Database\Seeders\CitySeeder;
use Modules\Machine\Entities\Machine;
use Modules\MachineModel\Database\Seeders\MachineModelSeeder;
use Modules\Manufacture\Database\Seeders\ManufactureSeeder;
use Modules\SubCategory\Database\Seeders\SubCategorySeeder;
use Modules\Subscription\Database\Seeders\SubscriptionSeeder;
use Modules\Upload\Database\Seeders\UploadSeeder;
use Modules\User\Database\Seeders\UserSeeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create(['name' => 'distributor','guard_name' => 'api']);
        Role::create(['name' => 'contractor','guard_name' => 'api']);

        if (User::all()->count() == 0) $this->call(UserSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(ManufactureSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(MachineModelSeeder::class);
        // $this->call(SubscriptionSeeder::class);
        // MachineModel::factory()->count(50)->create();
        //Machine::factory()->count(1000)->create();
    }
}
