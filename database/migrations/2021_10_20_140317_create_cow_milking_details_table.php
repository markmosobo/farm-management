<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCowMilkingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cow_milking_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_milking')->nullable();
            $table->string('cow_name')->nullable();
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
        Schema::dropIfExists('cow_milking_details');
    }
}
