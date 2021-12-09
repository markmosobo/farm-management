<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHybridTreatingOtherCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hybrid_treating_other_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_payment')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('hybrid_treating_other_costs');
    }
}
