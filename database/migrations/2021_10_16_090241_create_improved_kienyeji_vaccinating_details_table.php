<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprovedKienyejiVaccinatingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improved_kienyeji_vaccinating_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_vaccinating')->nullable();
            $table->bigInteger('poultry_id')->unsigned();
            $table->foreign('poultry_id')
                    ->references('id')
                    ->on('poultries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('no_of_poultries')->nullable();
            $table->string('vaccine_type')->nullable();
            $table->text('vaccine_quantity')->nullable();        
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
        Schema::dropIfExists('improved_kienyeji_vaccinating_details');
    }
}
