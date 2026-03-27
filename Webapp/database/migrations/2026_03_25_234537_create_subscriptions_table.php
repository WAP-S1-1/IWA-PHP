<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->float('price');
            $table->string('notes', 256)->nullable();
            $table->string('identifier', 45);
            $table->string('token', 100);

            $table->index('company', 'subscription_company_idx');
            $table->index('type', 'subscription_type_idx');
            $table->index('identifier', 'subscription_identifier');

            $table->foreign('company', 'subscription_company')
                ->references('id')
                ->on('companies');

            $table->foreign('type', 'subscription_type')
                ->references('id')
                ->on('subscription_types');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscription_company');
            $table->dropForeign('subscription_type');
        });

        Schema::dropIfExists('subscriptions');
    }
};
