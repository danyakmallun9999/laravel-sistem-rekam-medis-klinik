<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = \App\Models\Doctor::all();
        $patients = \App\Models\Patient::all();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            return;
        }

        $doctors = \App\Models\Doctor::all();
        $patients = \App\Models\Patient::all();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            return;
        }

        \App\Models\MedicalRecord::factory(100)
            ->recycle($doctors)
            ->recycle($patients)
            ->create();
    }
}
