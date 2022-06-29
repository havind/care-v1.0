<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrFinancePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_finance_passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mr_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fund_code_id');
            $table->unsignedBigInteger('budget_line_id');
            $table->integer('percentage');
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
        Schema::dropIfExists('mr_finance_passengers');
    }
}
