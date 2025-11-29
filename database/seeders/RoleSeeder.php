<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage patients',
            'manage doctors',
            'manage medical records',
            'view medical records',
            'manage pharmacy',
            'manage queues',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        
        // Admin: All permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Doctor: View/Manage Records, View Patients
        $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
        $doctorRole->givePermissionTo(['view medical records', 'manage medical records', 'view dashboard']);

        // Nurse: View/Manage Patients, View Records
        $nurseRole = Role::firstOrCreate(['name' => 'nurse']);
        $nurseRole->givePermissionTo(['manage patients', 'view medical records', 'view dashboard']);

        // Pharmacist: Manage Pharmacy
        $pharmacistRole = Role::firstOrCreate(['name' => 'pharmacist']);
        $pharmacistRole->givePermissionTo(['manage pharmacy', 'view dashboard']);

        // Front Office: Manage Queues, Manage Patients
        $frontOfficeRole = Role::firstOrCreate(['name' => 'front_office']);
        $frontOfficeRole->givePermissionTo(['manage queues', 'manage patients', 'view dashboard']);

        // Patient: View Own Records (Permissions handled via policy/logic mostly)
        $patientRole = Role::firstOrCreate(['name' => 'patient']);

        // Assign Admin role to the first user (if exists)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
