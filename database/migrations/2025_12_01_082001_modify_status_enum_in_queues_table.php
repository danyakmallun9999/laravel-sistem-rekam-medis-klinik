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
        Schema::table('queues', function (Blueprint $table) {
            // We need to drop the column and recreate it or modify it.
            // Since it's an enum, modification can be tricky in some DBs, but for MySQL/Laravel:
            // We can use DB::statement to modify the column directly for simplicity and robustness with enum changes.
            DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('waiting', 'waiting_screening', 'screening_completed', 'in_consultation', 'consultation_completed', 'waiting_pharmacy', 'waiting_payment', 'called', 'completed', 'skipped') DEFAULT 'waiting'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            // Update any rows with status NOT IN the old enum values to a default value (e.g., 'waiting')
            // to prevent "Data truncated" error when reverting the column.
            DB::table('queues')
                ->whereNotIn('status', ['waiting', 'called', 'completed', 'skipped'])
                ->update(['status' => 'waiting']);

            DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('waiting', 'called', 'completed', 'skipped') DEFAULT 'waiting'");
        });
    }
};
