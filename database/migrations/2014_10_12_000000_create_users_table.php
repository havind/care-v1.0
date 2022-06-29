<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->unsignedBigInteger('role_id');
            $table->string('personal_email')->unique()->nullable();
            $table->string('work_email')->unique()->nullable();
            $table->string('personal_phone')->unique()->nullable();
            $table->string('work_phone')->unique()->nullable();
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('acting_supervisor_id')->default(0);
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_delete')->default(false);
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
}
