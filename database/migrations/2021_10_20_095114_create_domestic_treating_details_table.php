<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomesticTreatingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domestic_treating_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_treating')->nullable();
            $table->bigInteger('animal_id')->unsigned();
            $table->foreign('animal_id')
                    ->references('id')
                    ->on('animals')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('no_of_animals')->nullable();
            $table->string('drug_type')->nullable();
            $table->text('drug_quantity')->nullable();        
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
        Schema::dropIfExists('domestic_treating_details');
    }
}
