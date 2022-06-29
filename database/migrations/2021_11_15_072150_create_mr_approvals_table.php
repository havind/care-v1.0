<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMrApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mr_id');
            $table->tinyInteger('line_manager_approval')->default(0);

            $table->unsignedBigInteger('items_approval_name')->nullable();
            $table->tinyInteger('items_approval')->default(0);
            $table->text('items_approval_reason')->nullable();
            $table->dateTime('items_approval_timestamp')->nullable();

            $table->unsignedBigInteger('risk_approval_name');
            $table->tinyInteger('risk_approval')->default(0);
            $table->text('risk_reason')->nullable();
            $table->dateTime('risk_timestamp')->nullable();

            $table->unsignedBigInteger('country_director_approval_name')->nullable();
            $table->tinyInteger('country_director_approval')->default(0);
            $table->text('country_director_reason')->nullable();
            $table->dateTime('country_director_timestamp')->nullable();

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
        Schema::dropIfExists('mr_approvals');
    }
}
