<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_station', function (Blueprint $table) {
            $table->unsignedInteger('subscription');
            $table->string('station', 10);

            $table->primary(['subscription', 'station']);
            $table->index('station', 'subscription_station_station_idx');

            $table->foreign('subscription', 'subscription_station_subscription_fk')
                ->references('id')
                ->on('subscriptions');

            $table->foreign('station', 'subscription_station_station_fk')
                ->references('name')
                ->on('station');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_station');
    }
};
