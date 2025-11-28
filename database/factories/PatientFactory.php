<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->unique()->numerify('################'),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
