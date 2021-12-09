<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCowMilkSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cow_milk_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_sale')->nullable();
            $table->float('quantity_sold')->nullable();
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
        Schema::dropIfExists('cow_milk_sales');
    }
}
