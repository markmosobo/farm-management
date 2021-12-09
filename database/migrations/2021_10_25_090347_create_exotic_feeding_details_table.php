<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExoticFeedingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exotic_feeding_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('poultry_id')->unsigned();
            $table->foreign('poultry_id')
                    ->references('id')
                    ->on('poultries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_feeding')->nullable();
            $table->string('feed_type')->nullable();
            $table->text('feed_quantity')->nullable();
            $table->integer('no_of_poultries')->nullable();
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
        Schema::dropIfExists('exotic_feeding_details');
    }
}
