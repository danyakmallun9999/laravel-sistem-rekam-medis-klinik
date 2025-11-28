<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BPJSController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
        ]);

        $nik = $request->nik;

        // Mock Logic
        // If NIK starts with '1', status is ACTIVE
        // If NIK starts with '0', status is INACTIVE
        // Otherwise, NOT FOUND

        if (str_starts_with($nik, '1')) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nik' => $nik,
                    'name' => 'BPJS User ' . substr($nik, -4),
                    'dob' => '1990-01-01',
                    'gender' => 'male',
                    'address' => 'Jl. Kesehatan No. 123, Jakarta',
                    'phone' => '08123456789',
                    'membership_status' => 'ACTIVE',
                    'class' => '1',
                ]
            ]);
        } elseif (str_starts_with($nik, '0')) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nik' => $nik,
                    'name' => 'Inactive User ' . substr($nik, -4),
                    'dob' => '1985-05-20',
                    'gender' => 'female',
                    'address' => 'Jl. Mawar No. 45, Bandung',
                    'phone' => '08987654321',
                    'membership_status' => 'INACTIVE',
                    'class' => '2',
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Peserta tidak ditemukan (Mock: Use NIK starting with 1 for Active, 0 for Inactive)',
            ], 404);
        }
    }
}
