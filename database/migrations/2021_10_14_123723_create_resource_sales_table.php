<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('resource_id')->unsigned();
            $table->foreign('resource_id')
                    ->references('id')
                    ->on('resources')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_selling')->nullable();
            $table->text('source_of_sale')->nullable();
            $table->text('sale_quantity')->nullable();
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
        Schema::dropIfExists('resource_sales');
    }
}
