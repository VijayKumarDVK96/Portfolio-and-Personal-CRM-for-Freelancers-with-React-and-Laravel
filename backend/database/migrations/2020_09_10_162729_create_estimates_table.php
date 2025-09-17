<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('estimate_number');
            $table->string('client_name');
            $table->string('company_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('tax')->default('0');
            $table->string('amount');
            $table->string('status')->default('Open'); // Open, Sent, Invoiced, Declined
            $table->string('estimate_date');
            $table->string('expiry_date');
            $table->text('description')->nullable();
            $table->integer('mail_sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimates');
    }
}
