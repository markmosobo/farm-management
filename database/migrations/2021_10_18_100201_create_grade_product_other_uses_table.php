<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradeProductOtherUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_product_other_uses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_of_retrieval')->nullable();
            $table->string('name')->nullable();
            $table->string('quantity_used')->nullable();
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
        Schema::dropIfExists('grade_product_other_uses');
    }
}
