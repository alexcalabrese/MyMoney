<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('label_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('label_id');
            $table->foreignId('transaction_id');
            $table->timestamps();
            
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            
            $table->unique(['label_id','transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label_transaction');
    }
}
