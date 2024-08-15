<?php

namespace Database\Seeders;

use App\Models\Duration;
//use App\Models\Duration;
use App\Models\Organization;
use App\Models\User;
use App\Models\Package;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Duration::factory()->count(20)->create();
        $this->call(ConfigurationsSeeder::class);
        Package::factory()->count(20)->create();
        $this->call(RoleSeeder::class);
        User::factory()->create();
        Organization::factory()->create();
    }

}
