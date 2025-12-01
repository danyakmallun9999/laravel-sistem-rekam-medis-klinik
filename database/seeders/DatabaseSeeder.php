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
            MedicineSeeder::class,
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

        // Create Schedules for Dr. Budi
        // Create Schedules
        // Shift 1: 08:00 - 14:00
        // Shift 2: 14:00 - 20:00
        
        $drBudiModel = \App\Models\Doctor::where('email', 'dr.budi@example.com')->first();
        $drSitiModel = \App\Models\Doctor::where('email', 'dr.siti@example.com')->first();
        $drAndiModel = \App\Models\Doctor::where('email', 'dr.andi@example.com')->first();

        $schedules = [
            // Monday
            ['doctor_id' => $drBudiModel->id, 'day_of_week' => 'monday', 'start_time' => '08:00', 'end_time' => '14:00'],
            ['doctor_id' => $drSitiModel->id, 'day_of_week' => 'monday', 'start_time' => '14:00', 'end_time' => '20:00'],
            // Tuesday
            ['doctor_id' => $drAndiModel->id, 'day_of_week' => 'tuesday', 'start_time' => '08:00', 'end_time' => '14:00'],
            ['doctor_id' => $drBudiModel->id, 'day_of_week' => 'tuesday', 'start_time' => '14:00', 'end_time' => '20:00'],
            // Wednesday
            ['doctor_id' => $drSitiModel->id, 'day_of_week' => 'wednesday', 'start_time' => '08:00', 'end_time' => '14:00'],
            ['doctor_id' => $drAndiModel->id, 'day_of_week' => 'wednesday', 'start_time' => '14:00', 'end_time' => '20:00'],
            // Thursday
            ['doctor_id' => $drBudiModel->id, 'day_of_week' => 'thursday', 'start_time' => '08:00', 'end_time' => '14:00'],
            ['doctor_id' => $drSitiModel->id, 'day_of_week' => 'thursday', 'start_time' => '14:00', 'end_time' => '20:00'],
            // Friday
            ['doctor_id' => $drAndiModel->id, 'day_of_week' => 'friday', 'start_time' => '08:00', 'end_time' => '14:00'],
            ['doctor_id' => $drBudiModel->id, 'day_of_week' => 'friday', 'start_time' => '14:00', 'end_time' => '20:00'],
        ];

        foreach ($schedules as $schedule) {
            \App\Models\Schedule::create(array_merge($schedule, ['is_available' => true]));
        }
    }
}
