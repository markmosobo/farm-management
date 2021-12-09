<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherAnimalMilkingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_animal_milking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_milking')->nullable();
            $table->bigInteger('animal_id')->unsigned();
            $table->foreign('animal_id')
                    ->references('id')
                    ->on('animals')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('animal_code')->nullable();
            $table->float('milk_quantity')->nullable();
            $table->string('milker_name')->nullable();        
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
        Schema::dropIfExists('other_animal_milking_details');
    }
}
