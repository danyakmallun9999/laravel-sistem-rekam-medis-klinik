<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        // Create other role users
        // Create 3 specific Doctor Users
        $drBudi = User::factory()->create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dr.budi@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $drSiti = User::factory()->create([
            'name' => 'Dr. Siti Aminah',
            'email' => 'dr.siti@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $drAndi = User::factory()->create([
            'name' => 'Dr. Andi Wijaya',
            'email' => 'dr.andi@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        // Create corresponding Doctor profiles
        \App\Models\Doctor::create([
            'name' => 'Dr. Budi Santoso',
            'specialization' => 'Umum',
            'phone' => '081234567890',
            'email' => 'dr.budi@example.com',
        ]);

        \App\Models\Doctor::create([
            'name' => 'Dr. Siti Aminah',
            'specialization' => 'Anak',
            'phone' => '081234567891',
            'email' => 'dr.siti@example.com',
        ]);

        \App\Models\Doctor::create([
            'name' => 'Dr. Andi Wijaya',
            'specialization' => 'Gigi',
            'phone' => '081234567892',
            'email' => 'dr.andi@example.com',
        ]);

        $nurse = User::factory()->create([
            'name' => 'Nurse User',
            'email' => 'nurse@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $pharmacist = User::factory()->create([
            'name' => 'Pharmacist User',
            'email' => 'pharmacist@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $frontOffice = User::factory()->create([
            'name' => 'Front Office User',
            'email' => 'frontoffice@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $this->call([
            RoleSeeder::class,
            PatientSeeder::class,
            // DoctorSeeder::class, // Removed generic doctor seeder
            MedicalRecordSeeder::class,
        ]);

        // Assign roles
        $drBudi->assignRole('doctor');
        $drSiti->assignRole('doctor');
        $drAndi->assignRole('doctor');
        $nurse->assignRole('nurse');
        $pharmacist->assignRole('pharmacist');
        $frontOffice->assignRole('front_office');
    }
}
