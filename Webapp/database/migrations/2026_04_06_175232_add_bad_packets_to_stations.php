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
        Schema::table('station', function (Blueprint $table) {
            $table->unsignedInteger('last_100_bad_count')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('station', function (Blueprint $table) {
            $table->dropColumn('last_100_bad_count');
        });
    }
};
