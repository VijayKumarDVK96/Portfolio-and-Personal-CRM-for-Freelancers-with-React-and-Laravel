<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_statements', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('payment_type')->comment('Cash, Online Transfer, Cheque');
            $table->string('paid_amount');
            $table->string('paid_at');
            $table->integer('statement_type')->comment('0 - Debit, 1 - Credit');
            $table->string('purpose')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('account_statements');
    }
}
