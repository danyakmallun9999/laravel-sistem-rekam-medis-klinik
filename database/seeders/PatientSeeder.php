<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Patient::factory(25)->create()->each(function ($patient) {
            // Create 1-5 medical records for each patient
            \App\Models\MedicalRecord::factory(rand(1, 5))->create([
                'patient_id' => $patient->id,
                'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()->id ?? \App\Models\Doctor::factory()->create()->id,
            ]);
        });
    }
}
