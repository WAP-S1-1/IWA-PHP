<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nearestlocation', function (Blueprint $table) {
            $table->increments('id');

            $table->string('station_name', 10);
            $table->string('name', 100)->nullable();
            $table->string('administrative_region1', 100)->nullable();
            $table->string('administrative_region2', 100)->nullable();
            $table->char('country_code', 2);

            $table->float('longitude');
            $table->float('latitude');

            // Foreign keys
            $table->foreign('country_code')
                ->references('country_code')
                ->on('country')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('station_name')
                ->references('name')
                ->on('station')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->index('station_name', 'fk_nearestlocation_station_name');
            $table->index('country_code', 'fk_nearestlocation_country_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nearestlocation');
    }
};
