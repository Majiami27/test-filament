<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'superAdmin',
            'email' => 'superAdmin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        $superAdmin->assignRole('super_admin');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => bcrypt('admin123'),
            'organization_id' => $admin->id,
        ]);

        $user->assignRole('user');

        $admin2 = User::create([
            'name' => 'admin2',
            'email' => 'admin2@example.com',
            'password' => bcrypt('admin123'),
        ]);

        $admin2->assignRole('admin');
    }
}
