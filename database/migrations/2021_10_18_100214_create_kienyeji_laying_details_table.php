<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKienyejiLayingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kienyeji_laying_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_laying')->nullable();
            $table->bigInteger('poultry_id')->unsigned();
            $table->foreign('poultry_id')
                    ->references('id')
                    ->on('poultries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('poultry_code')->nullable();
            $table->integer('no_of_eggs')->nullable();        
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
        Schema::dropIfExists('kienyeji_laying_details');
    }
}
