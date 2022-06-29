<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_passengers', function (Blueprint $table) {
            $table->id();
            $table->string('mr_id');
            $table->unsignedBigInteger('passenger_id');
            $table->unsignedBigInteger('passenger_supervisor_id');
            $table->unsignedBigInteger('passenger_acting_supervisor_id');
            $table->tinyInteger('line_manager_approval')->default(0);
            $table->text('line_manager_reason')->nullable();
            $table->dateTime('line_manager_timestamp')->nullable();
            $table->boolean('is_delete')->default(false);
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
        Schema::dropIfExists('mr_passengers');
    }
}
