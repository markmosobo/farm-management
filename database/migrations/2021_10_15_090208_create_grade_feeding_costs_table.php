<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeFeedingCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_feeding_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('feed_type')->nullable();
            $table->bigInteger('poultry_id')
                    ->references('id')
                    ->on('poultries')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->date('date_of_purchase')->nullable();
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
        Schema::dropIfExists('grade_feeding_costs');
    }
}
