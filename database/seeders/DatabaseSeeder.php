<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'SUPER ADMIN',
            'email' => 'neobeyondtech@gmail.com',
            'role' => 1, // SUPER ADMIN
            'password' => bcrypt('Bismillah#2026'),
            'email_verified_at' => now(),
        ]);

        $this->call([
            CustomerCategorySeeder::class,
            CustomerTypeSeeder::class,
            MasterLocationSeeder::class,
            VehicleBrandSeeder::class,
            MasterBanksSeeder::class,
        ]);
    }
}
