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
            $table->string('status')->default('online')->after('elevation');
            $table->timestamp('status_updated_at')->nullable()->after('status');
            $table->text('status_message')->nullable()->after('status_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('station', function (Blueprint $table) {
            //
        });
    }
};
