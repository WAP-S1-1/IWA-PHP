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
        // Create userroles table
        Schema::create('userroles', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT primary key
            $table->string('role', 45)->unique();
            $table->string('description', 256)->nullable();
        });

        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true); // AUTO_INCREMENT primary key
            $table->string('name', 100);
            $table->string('first_name', 45)->nullable();
            $table->string('initials', 12)->nullable();
            $table->string('prefix', 10)->nullable();
            $table->string('email', 100);
            $table->string('employee_code', 10);
            $table->integer('user_role'); // foreign key
            $table->string('password', 256);

            $table->foreign('user_role')
                ->references('id')
                ->on('userroles')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // MySQL default for InnoDB
            $table->index('user_role', 'role_for_user_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('userroles');
    }
};
