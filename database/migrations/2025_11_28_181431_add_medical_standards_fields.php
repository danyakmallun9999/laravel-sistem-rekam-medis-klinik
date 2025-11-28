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
        Schema::table('patients', function (Blueprint $table) {
            $table->text('allergies')->nullable()->after('phone');
            $table->text('medical_history')->nullable()->after('allergies');
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('icd10_code')->nullable()->after('diagnosis');
            $table->string('icd10_name')->nullable()->after('icd10_code');
            $table->string('icd9_code')->nullable()->after('icd10_name');
            $table->string('icd9_name')->nullable()->after('icd9_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['allergies', 'medical_history']);
        });

        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['icd10_code', 'icd10_name', 'icd9_code', 'icd9_name']);
        });
    }
};
