<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Compliance Fields
            $table->datetime('visit_date')->change(); // Change date to datetime to include time
            $table->boolean('is_signed')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->string('responsible_person_name')->nullable();
            $table->string('responsible_person_relationship')->nullable();
            $table->text('allergies')->nullable();
            $table->boolean('informed_consent_signed')->default(false);
            $table->string('discharge_status')->nullable(); // Sembuh, Perbaikan, Rujuk, Pulang Paksa, Meninggal
            $table->string('referral_hospital')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->date('visit_date')->change(); // Revert to date
            $table->dropColumn([
                'is_signed',
                'signed_at',
                'responsible_person_name',
                'responsible_person_relationship',
                'allergies',
                'informed_consent_signed',
                'discharge_status',
                'referral_hospital',
            ]);
        });
    }
};
