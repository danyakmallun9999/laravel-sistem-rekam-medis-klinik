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
        $faker = \Faker\Factory::create('id_ID');
        
        return [
            'name' => $faker->name(),
            'nik' => $faker->unique()->numerify('################'), // 16 digits
            'dob' => $faker->date('Y-m-d', '-10 years'),
            'gender' => $faker->randomElement(['male', 'female']),
            'address' => $faker->address(),
            'phone' => $faker->phoneNumber(),
            'bpjs_number' => $faker->unique()->numerify('000##########'), // Mock BPJS
            'blood_type' => $faker->randomElement(['A', 'B', 'AB', 'O']),
            'allergies' => $faker->optional(0.2)->randomElement(['Kacang', 'Seafood', 'Antibiotik', 'Debu', 'Telur']),
            'medical_history' => $faker->optional(0.3)->sentence(),
        ];
    }
}
