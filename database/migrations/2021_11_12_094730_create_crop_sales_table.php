<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCropSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('crop_id')->unsigned();
            $table->foreign('crop_id')
                    ->references('id')
                    ->on('crops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_selling')->nullable();
            $table->string('name_of_buyer')->nullable();
            $table->string('quantity_sold')->nullable();
            $table->float('amount_due')->nullable(); 
            $table->integer('status')->nullable();       
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
        Schema::dropIfExists('crop_sales');
    }
}
