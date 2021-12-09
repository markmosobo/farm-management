<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprovedKienyejiProductOtherUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improved_kienyeji_product_other_uses', function (Blueprint $table) {
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
        Schema::dropIfExists('improved_kienyeji_product_other_uses');
    }
}
