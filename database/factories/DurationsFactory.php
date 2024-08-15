<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DurationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'duration'=>random_int(3,10),
        ];
    }
}
