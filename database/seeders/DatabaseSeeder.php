<?php

namespace Database\Seeders;

use App\Models\Duration;
use App\Models\Durations;
use App\Models\Organization;
use App\Models\User;
use App\Models\Packages;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Durations::factory()->count(20)->create();
        $this->call(ConfigurationsSeeder::class);
        packages::factory()->count(20)->create();
        $this->call(RoleSeeder::class);
        User::factory()->create();
        Organization::factory()->create();
    }
    
}