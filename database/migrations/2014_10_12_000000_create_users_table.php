<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role_as')->default('0');
            $table->string('name', 255); // 255 character limit
            $table->string('email', 255)->unique(); // 255 character limit
            $table->timestamp('email_verified_at')->nullable();
            $table->string('employee_id', 20); // 20 character limit for employee ID
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
