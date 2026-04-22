<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure column exists (cross-compatible)
        if (!Schema::hasColumn('station', 'last_100_bad_count')) {
            Schema::table('station', function (Blueprint $table) {
                $table->unsignedInteger('last_100_bad_count')->default(0);
            });
        }

        // Drop trigger if exists
        DB::statement("DROP TRIGGER IF EXISTS measurement_after_insert");

        // Create trigger
        DB::statement("
        CREATE TRIGGER measurement_after_insert
        AFTER INSERT ON measurement
        FOR EACH ROW
        BEGIN
            DECLARE bad_count INT;

            SELECT COUNT(*) INTO bad_count
            FROM (
                SELECT om.corrected_measurement
                FROM measurement m
                JOIN original_measurement om
                    ON om.corrected_measurement = m.id
                WHERE m.station = NEW.station
                ORDER BY m.date DESC, m.time DESC
                LIMIT 100
            ) AS last_100;

            UPDATE station
            SET last_100_bad_count = bad_count
            WHERE name = NEW.station;
        END;
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS measurement_after_insert");

        DB::table('station')->update(['last_100_bad_count' => 0]);
    }
};
