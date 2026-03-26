<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('city', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->integer('number')->nullable();
            $table->string('number_additional', 15)->nullable();
            $table->string('zip_code', 15)->nullable();
            $table->string('country', 2);
            $table->string('email', 100)->nullable();

            $table->index('country', 'company_country_idx');

            $table->foreign('country', 'company_country')
                ->references('country_code')
                ->on('country');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('company_country');
        });

        Schema::dropIfExists('companies');
    }
};
