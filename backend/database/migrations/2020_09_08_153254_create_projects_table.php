<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->integer('projects_category_id');
            $table->integer('client_id')->unsigned();
            $table->string('cover_image')->nullable();
            $table->integer('status')->default(0);
            $table->text('description')->nullable();
            $table->string('estimated_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('url')->nullable();
            $table->string('project_url')->nullable();
            $table->string('deadline');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
