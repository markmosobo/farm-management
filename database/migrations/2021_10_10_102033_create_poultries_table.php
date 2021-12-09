<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoultriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poultries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('owner_id')->unsigned();
            $table->foreign('owner_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');            
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('no_of_poultries')->nullable();
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
        Schema::dropIfExists('poultries');
    }
}
