<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToOriginalMeasurementTable extends Migration
{
    public function up()
    {
        Schema::table('original_measurement', function (Blueprint $table) {
            // Alleen toevoegen als deze nog niet bestaan
            if (!Schema::hasColumn('original_measurement', 'original_data')) {
                $table->json('original_data')->nullable()->after('inavlid_temperature');
            }

            if (!Schema::hasColumn('original_measurement', 'correction_reason')) {
                $table->text('correction_reason')->nullable()->after('original_data');
            }

            // Optioneel: timestamps toevoegen als je die wilt bijhouden
            if (!Schema::hasColumn('original_measurement', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down()
    {
        Schema::table('original_measurement', function (Blueprint $table) {
            $table->dropColumn(['original_data', 'correction_reason', 'created_at', 'updated_at']);
        });
    }
}
