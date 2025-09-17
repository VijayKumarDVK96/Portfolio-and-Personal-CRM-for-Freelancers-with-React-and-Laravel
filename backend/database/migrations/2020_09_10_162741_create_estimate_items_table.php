<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estimate_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->string('quantity');
            $table->string('unit_price');
            $table->string('total_price');
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimate_items');
    }
}
