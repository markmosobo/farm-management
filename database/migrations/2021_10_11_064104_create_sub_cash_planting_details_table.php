<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCashPlantingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_cash_planting_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_planting')->nullable();
            $table->bigInteger('crop_id')->unsigned();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->float('acreage_planted')->nullable();
            $table->string('fertilizer_type')->nullable();
            $table->longText('fertilizer_quantity')->nullable();
            $table->longText('seed_quantity')->nullable();        
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
        Schema::dropIfExists('sub_cash_planting_details');
    }
}
