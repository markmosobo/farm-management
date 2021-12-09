<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprovedKienyejiEggSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improved_kienyeji_egg_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_sale')->nullable();
            $table->bigInteger('poultry_id')->unsigned();
            $table->foreign('poultry_id')
                    ->references('id')
                    ->on('poultries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->integer('no_sold')->nullable();
            $table->float('amount_got')->nullable();        
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
        Schema::dropIfExists('improved_kienyeji_egg_sales');
    }
}
