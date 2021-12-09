<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPlantingFertilizerCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_planting_fertilizer_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fertilizer_type')->nullable();
            $table->bigInteger('crop_id')->unsigned();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');            
            $table->date('date_of_purchase')->nullable();
            $table->string('quantity_bought')->nullable();
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
        Schema::dropIfExists('cash_planting_fertilizer_costs');
    }
}
