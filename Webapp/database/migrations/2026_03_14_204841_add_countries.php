<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Country table
        Schema::create('country', function (Blueprint $table) {
            $table->string('country_code', 2)->primary();
            $table->string('country', 45);
        });

        // Geolocation table
        Schema::create('geolocation', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT primary key
            $table->string('station_name', 10);
            $table->string('country_code', 2);
            $table->string('island', 100)->nullable();
            $table->string('county', 100)->nullable();
            $table->string('place', 100)->nullable();
            $table->string('hamlet', 100)->nullable();
            $table->string('town', 100)->nullable();
            $table->string('municipality', 100)->nullable();
            $table->string('state_district', 100)->nullable();
            $table->string('administrative', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('village', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('locality', 100)->nullable();
            $table->string('postcode', 100)->nullable();
            $table->string('country', 100)->nullable();

            // Foreign keys
            $table->foreign('station_name')->references('name')->on('station');
            $table->foreign('country_code')->references('country_code')->on('country');

            // Indexes
            $table->index('station_name', 'fk_geolocation_station_name');
            $table->index('country_code', 'fk_geolocation_country_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geolocation');
        Schema::dropIfExists('country');
    }
};
