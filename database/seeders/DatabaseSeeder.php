<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;

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
        Role::create(['name' => 'seller','guard_name' => 'api']);
        Role::create(['name' => 'buyer','guard_name' => 'api']);

        if (User::all()->count() == 0) $this->call(UserSeeder::class);
        $this->call(UploadSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(ManufactureSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(MachineModelSeeder::class);
        // MachineModel::factory()->count(50)->create();
        Machine::factory()->count(100)->create();    }
}
