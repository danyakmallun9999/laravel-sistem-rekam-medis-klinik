<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::factory(),
            'diagnosis' => fake()->sentence(),
            'treatment' => fake()->paragraph(),
            'prescription' => fake()->text(),
            'visit_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'vital_signs' => [
                'systolic' => fake()->numberBetween(100, 140),
                'diastolic' => fake()->numberBetween(60, 90),
                'heart_rate' => fake()->numberBetween(60, 100),
                'respiratory_rate' => fake()->numberBetween(12, 20),
                'temperature' => fake()->randomFloat(1, 36.0, 37.5),
                'weight' => fake()->numberBetween(45, 90),
                'height' => fake()->numberBetween(150, 180),
            ],
            'soap_data' => [
                'subjective' => fake()->paragraph(),
                'objective' => fake()->paragraph(),
                'assessment' => fake()->paragraph(),
                'plan' => fake()->paragraph(),
            ],
            'icd10_code' => fake()->regexify('[A-Z][0-9]{2}\.[0-9]'),
            'icd10_name' => fake()->words(3, true),
            'icd9_code' => fake()->regexify('[0-9]{2}\.[0-9]{2}'),
            'icd9_name' => fake()->words(2, true),
        ];
    }
}
