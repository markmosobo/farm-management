<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomesticDrugCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domestic_drug_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_purchase')->nullable();
            $table->string('drug_type')->nullable();
            $table->bigInteger('animal_id')->unsigned();
            $table->foreign('animal_id')
                    ->references('id')
                    ->on('animals')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->text('quantity_bought')->nullable();
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
        Schema::dropIfExists('domestic_drug_costs');
    }
}
