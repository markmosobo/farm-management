<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPreparingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_preparing_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('crop_id')->unsigned()->nullable();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_preparing')->nullable();
            $table->longText('activity')->nullable();
            $table->string('tools_used')->nullable();
            $table->float('acreage_prepared')->nullable();        
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
        Schema::dropIfExists('cash_preparing_details');
    }
}
