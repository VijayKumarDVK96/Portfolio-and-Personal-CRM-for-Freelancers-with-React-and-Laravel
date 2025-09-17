<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('project_id')->nullable();
            $table->string('invoice_id');
            $table->string('tax')->default('0');
            $table->string('amount');
            $table->string('payment_mode');
            $table->string('status')->default('Open'); // Open, Paid, Partially Paid, Cancelled, Refunded
            $table->string('invoice_date');
            $table->string('due_date');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
