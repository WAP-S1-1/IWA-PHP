<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make sure the column exists first
        DB::statement("
            ALTER TABLE station
            ADD COLUMN IF NOT EXISTS last_100_bad_count INT UNSIGNED NOT NULL DEFAULT 0
        ");

        // Drop trigger if it exists
        DB::statement("DROP TRIGGER IF EXISTS measurement_after_insert");

        // Create trigger
        DB::statement("
            CREATE TRIGGER measurement_after_insert
            AFTER INSERT ON measurement
            FOR EACH ROW
            BEGIN
                DECLARE bad_count INT;

                -- Count bad packets among the last 100 measurements for this station
                SELECT COUNT(*) INTO bad_count
                FROM (
                    SELECT om.corrected_measurement
                    FROM measurement m
                    JOIN original_measurement om
                        ON om.corrected_measurement = m.id
                    WHERE m.station = NEW.station
                    ORDER BY m.date DESC, m.time DESC
                    LIMIT 100
                ) last_100;

                -- Update station's last_100_bad_count
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
