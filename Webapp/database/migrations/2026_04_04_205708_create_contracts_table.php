<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('omschrijving', 45);
            $table->date('start_datum');
            $table->date('eind_datum')->nullable();
            $table->string('url', 100);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('query', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->string('omschrijving', 256);
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contract')->onDelete('cascade');
            $table->index('contract_id');
        });

        Schema::create('criterium_type', function (Blueprint $table) {
            $table->id();
            $table->string('omschrijving', 45);
            $table->string('referenced_table', 45);
            $table->string('referenced_field', 45);
        });

        Schema::create('operator_type', function (Blueprint $table) {
            $table->id();
            $table->string('omschrijving', 45);
        });

        Schema::create('comparison_operator_type', function (Blueprint $table) {
            $table->id();
            $table->string('omschrijving', 45);
        });

        Schema::create('criterium_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query');
            $table->unsignedBigInteger('type');
            $table->unsignedBigInteger('group_table');
            $table->unsignedBigInteger('operator');
            $table->timestamps();

            $table->foreign('query')->references('id')->on('query')->onDelete('cascade');
            $table->foreign('type')->references('id')->on('criterium_type')->onDelete('cascade');
            $table->foreign('operator')->references('id')->on('operator_type')->onDelete('cascade');
            $table->index('query');
        });

        Schema::create('criterium', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group');
            $table->unsignedBigInteger('operator');
            $table->integer('int_value')->nullable();
            $table->string('string_value', 45)->nullable();
            $table->float('float_value')->nullable();
            $table->unsignedBigInteger('value_type');
            $table->unsignedBigInteger('value_comparison');
            $table->timestamps();

            $table->foreign('group')->references('id')->on('criterium_group')->onDelete('cascade');
            $table->foreign('operator')->references('id')->on('operator_type')->onDelete('cascade');
            $table->foreign('value_comparison')->references('id')->on('comparison_operator_type')->onDelete('cascade');
            $table->index('group');
        });
    }

    public function down(): void
    {
        // ✓ Fixed: Drop in REVERSE order
        Schema::dropIfExists('criterium');
        Schema::dropIfExists('criterium_group');
        Schema::dropIfExists('comparison_operator_type');
        Schema::dropIfExists('operator_type');
        Schema::dropIfExists('criterium_type');
        Schema::dropIfExists('query');
        Schema::dropIfExists('contract');
    }
};
