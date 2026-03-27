<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_station', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription');
            $table->string('station', 10);

            $table->primary(['subscription', 'station']);

            $table->index('station', 'station_subscription');

            $table->foreign('subscription', 'company_subscription')
                ->references('id')
                ->on('subscriptions');

            $table->foreign('station', 'station_subscription')
                ->references('name')
                ->on('station');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_station', function (Blueprint $table) {
            $table->dropForeign('company_subscription');
            $table->dropForeign('station_subscription');
        });

        Schema::dropIfExists('subscription_station');
    }
};
