<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mr_id');
            $table->unsignedBigInteger('user_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedBigInteger('location_id');
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
        Schema::dropIfExists('mr_accommodations');
    }
}
