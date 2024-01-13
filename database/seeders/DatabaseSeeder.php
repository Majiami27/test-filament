<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->call([
                RoleSeeder::class,
            ]);
        }

        if (app()->environment('local')) {
            $this->call([
                RoleSeeder::class,
                UserSeeder::class,
                AreaSeeder::class,
                DeviceSeeder::class,
            ]);
        }
    }
}
