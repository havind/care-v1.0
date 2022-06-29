<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_itineraries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mr_id');
            $table->unsignedBigInteger('from_location_id');
            $table->date('from_date');
            $table->time('from_time');
            $table->unsignedBigInteger('to_location_id');
            $table->date('to_date');
            $table->time('to_time');
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
        Schema::dropIfExists('mr_itineraries');
    }
}
