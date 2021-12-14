<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
            'first_name' => 'User',
            'last_name' => 'User',
            'company_name' => 'Company',
            'email' => 'user@user.com',
            'password' => bcrypt('12345678'),
        ];
        $admin = [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'company_name' => 'Company',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ];
        $admin = User::create($admin);
        $user = User::create($user1);


        $role = Role::find(1)->first();
        $user->assignRole($role);
        $admin->assignRole($role);
    }
}
