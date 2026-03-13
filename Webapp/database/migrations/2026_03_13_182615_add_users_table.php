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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); // auto-increment primary key
            $table->string('name', 100);
            $table->string('first_name', 45)->nullable();
            $table->string('initials', 12)->nullable();
            $table->string('prefix', 10)->nullable();
            $table->string('email', 100);
            $table->string('employee_code', 10);
            $table->integer('user_role');
            $table->string('password', 256);

            $table->index('user_role', 'role_for_user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
