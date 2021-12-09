<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCashWeedingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_cash_weeding_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_weeding')->nullable();
            $table->bigInteger('crop_id')->unsigned();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('chemical_type')->nullable();
            $table->float('acreage_weeded')->nullable();
            $table->text('tools_used')->nullable();
            $table->text('chemical_quantity')->nullable();        
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
        Schema::dropIfExists('sub_cash_weeding_details');
    }
}
