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
            // Analgesics & Antipyretics
            ['name' => 'Paracetamol 500mg', 'stock' => 1000, 'min_stock' => 100, 'price' => 5000, 'batch_number' => 'BATCH001', 'expired_date' => '2025-12-31'],
            ['name' => 'Ibuprofen 400mg', 'stock' => 800, 'min_stock' => 50, 'price' => 8000, 'batch_number' => 'BATCH003', 'expired_date' => '2026-01-31'],
            ['name' => 'Asam Mefenamat 500mg', 'stock' => 500, 'min_stock' => 50, 'price' => 7000, 'batch_number' => 'BATCH006', 'expired_date' => '2025-11-30'],
            
            // Antibiotics
            ['name' => 'Amoxicillin 500mg', 'stock' => 500, 'min_stock' => 50, 'price' => 15000, 'batch_number' => 'BATCH002', 'expired_date' => '2025-10-31'],
            ['name' => 'Cefadroxil 500mg', 'stock' => 300, 'min_stock' => 30, 'price' => 18000, 'batch_number' => 'BATCH007', 'expired_date' => '2025-09-30'],
            ['name' => 'Azithromycin 500mg', 'stock' => 200, 'min_stock' => 20, 'price' => 25000, 'batch_number' => 'BATCH008', 'expired_date' => '2026-03-31'],

            // Antihistamines
            ['name' => 'Cetirizine 10mg', 'stock' => 600, 'min_stock' => 60, 'price' => 3000, 'batch_number' => 'BATCH004', 'expired_date' => '2025-11-30'],
            ['name' => 'Loratadine 10mg', 'stock' => 400, 'min_stock' => 40, 'price' => 4000, 'batch_number' => 'BATCH009', 'expired_date' => '2026-02-28'],
            ['name' => 'CTM 4mg', 'stock' => 1000, 'min_stock' => 100, 'price' => 1000, 'batch_number' => 'BATCH010', 'expired_date' => '2025-12-31'],

            // Vitamins
            ['name' => 'Vitamin C 500mg', 'stock' => 2000, 'min_stock' => 200, 'price' => 2000, 'batch_number' => 'BATCH005', 'expired_date' => '2026-06-30'],
            ['name' => 'Vitamin B Complex', 'stock' => 1500, 'min_stock' => 150, 'price' => 3000, 'batch_number' => 'BATCH011', 'expired_date' => '2026-05-31'],
            ['name' => 'Vitamin D3 1000IU', 'stock' => 800, 'min_stock' => 80, 'price' => 5000, 'batch_number' => 'BATCH012', 'expired_date' => '2026-08-31'],

            // Cough & Cold
            ['name' => 'OBH Syrup 100ml', 'stock' => 200, 'min_stock' => 20, 'price' => 15000, 'batch_number' => 'BATCH013', 'expired_date' => '2025-08-31'],
            ['name' => 'Ambroxol 30mg', 'stock' => 600, 'min_stock' => 60, 'price' => 2500, 'batch_number' => 'BATCH014', 'expired_date' => '2025-10-31'],
            ['name' => 'GG (Guaifenesin) 100mg', 'stock' => 500, 'min_stock' => 50, 'price' => 2000, 'batch_number' => 'BATCH015', 'expired_date' => '2025-11-30'],

            // Gastrointestinal
            ['name' => 'Omeprazole 20mg', 'stock' => 400, 'min_stock' => 40, 'price' => 5000, 'batch_number' => 'BATCH016', 'expired_date' => '2026-01-31'],
            ['name' => 'Ranitidine 150mg', 'stock' => 300, 'min_stock' => 30, 'price' => 3000, 'batch_number' => 'BATCH017', 'expired_date' => '2025-09-30'],
            ['name' => 'Antasida Doen', 'stock' => 500, 'min_stock' => 50, 'price' => 2000, 'batch_number' => 'BATCH018', 'expired_date' => '2025-12-31'],

            // Others
            ['name' => 'Amlodipine 5mg', 'stock' => 600, 'min_stock' => 60, 'price' => 4000, 'batch_number' => 'BATCH019', 'expired_date' => '2026-04-30'],
            ['name' => 'Amlodipine 10mg', 'stock' => 500, 'min_stock' => 50, 'price' => 6000, 'batch_number' => 'BATCH020', 'expired_date' => '2026-04-30'],
            ['name' => 'Metformin 500mg', 'stock' => 800, 'min_stock' => 80, 'price' => 3000, 'batch_number' => 'BATCH021', 'expired_date' => '2026-03-31'],
            ['name' => 'Simvastatin 10mg', 'stock' => 400, 'min_stock' => 40, 'price' => 5000, 'batch_number' => 'BATCH022', 'expired_date' => '2026-02-28'],
        ];

        foreach ($medicines as $medicine) {
            \App\Models\Medicine::create($medicine);
        }
    }
}
