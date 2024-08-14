<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PackagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'period' => random_int(0,10),
            'cost' => random_int(50,1000),
            'operations_count' => random_int(20,100),
            'duration_id' => random_int(1,20),
        ];
    }
}
