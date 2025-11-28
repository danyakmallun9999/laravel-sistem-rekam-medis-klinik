<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'stock' => 1000, 'price' => 5000, 'batch_number' => 'BATCH001', 'expired_date' => '2025-12-31'],
            ['name' => 'Amoxicillin 500mg', 'stock' => 500, 'price' => 15000, 'batch_number' => 'BATCH002', 'expired_date' => '2025-10-31'],
            ['name' => 'Ibuprofen 400mg', 'stock' => 800, 'price' => 8000, 'batch_number' => 'BATCH003', 'expired_date' => '2026-01-31'],
            ['name' => 'Cetirizine 10mg', 'stock' => 600, 'price' => 3000, 'batch_number' => 'BATCH004', 'expired_date' => '2025-11-30'],
            ['name' => 'Vitamin C 500mg', 'stock' => 2000, 'price' => 2000, 'batch_number' => 'BATCH005', 'expired_date' => '2026-06-30'],
        ];

        foreach ($medicines as $medicine) {
            \App\Models\Medicine::create($medicine);
        }
    }
}
