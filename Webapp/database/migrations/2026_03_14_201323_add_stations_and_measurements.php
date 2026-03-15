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
        // Station table
        Schema::create('station', function (Blueprint $table) {
            $table->string('name', 10)->primary();
            $table->float('longitude');
            $table->float('latitude');
            $table->float('elevation');
        });

        // Measurement table
        Schema::create('measurement', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT primary key
            $table->string('station', 10)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->float('temperature')->nullable();
            $table->float('dewpoint_temperature')->nullable();
            $table->float('air_pressure_station')->nullable();
            $table->float('air_pressure_sea_level')->nullable();
            $table->float('visibility')->nullable();
            $table->float('wind_speed')->nullable();
            $table->float('percipation')->nullable(); // TODO: Fix typo
            $table->float('snow_depth')->nullable();
            $table->string('conditions', 6)->nullable();
            $table->float('cloud_cover')->nullable();
            $table->integer('wind_direction')->nullable();

            $table->foreign('station')
                ->references('name')
                ->on('station')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->index('station', 'measurement_station');
        });

        // Original Measurement table
        Schema::create('original_measurement', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT primary key
            $table->integer('corrected_measurement');
            $table->string('missing_field', 32)->nullable();
            $table->float('inavlid_temperature')->nullable(); // TODO: Fix typo

            $table->foreign('corrected_measurement')
                ->references('id')
                ->on('measurement')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->index('corrected_measurement', 'measurement_correction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('original_measurement');
        Schema::dropIfExists('measurement');
        Schema::dropIfExists('station');
    }
};
