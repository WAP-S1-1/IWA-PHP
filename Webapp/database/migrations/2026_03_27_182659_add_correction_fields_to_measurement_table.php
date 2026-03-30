<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorrectionFieldsToMeasurementTable extends Migration
{
    public function up()
    {
        Schema::table('measurement', function (Blueprint $table) {
            $table->boolean('is_corrected')->default(false)->after('wind_direction');
            $table->json('correction_details')->nullable()->after('is_corrected');
        });
    }

    public function down()
    {
        Schema::table('measurement', function (Blueprint $table) {
            $table->dropColumn(['is_corrected', 'correction_details']);
        });
    }
}
