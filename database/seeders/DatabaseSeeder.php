<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Builder;
use App\Models\Division;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create demo admin user
        User::factory()->create([
            'name' => 'Laravel Admin',
            'email' => env('API_TEST_USER_NAME'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);

        // \App\Models\User::factory(10)->create();
        Builder::factory(2)->create();
        Division::factory(4)->create();
    }
}
