<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->company(),
            'commercial_register_number'=>random_int(111111111,999999999),
            'tax_card_number'=>random_int(100000,999999),
            'users_count'=>random_int(1,1000),
            'revisers_count'=>random_int(1,1000),
            'operations_count'=>random_int(10,1000),
            'user_id'=>1,
            'package_id'=>4,
        ];
    }
}
