<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Builder;
use App\Models\Division;
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
        // \App\Models\User::factory(10)->create();
        User::factory(2)->create();
        Builder::factory(2)->create();
        Division::factory(4)->create();
        
    }
}
