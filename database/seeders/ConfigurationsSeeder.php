<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create(['key'=>'About', 'value'=> 'This is the about data' ]);
        Configuration::create(['key'=>'Footer', 'value'=> 'This is the data in the footer' ]);
    }
}
