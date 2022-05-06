<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPreparingLabourCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_preparing_labour_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('crop_id')->unsigned()->nullable();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_work')->nullable();
            $table->integer('no_of_persons')->nullable();
            $table->float('amount_paid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_preparing_labour_costs');
    }
}
