<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vault', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vaults_category_id');
            $table->integer('project_id')->unsigned();
            $table->string('url');
            $table->text('username');
            $table->text('password');
            $table->text('notes')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vault');
    }
}
