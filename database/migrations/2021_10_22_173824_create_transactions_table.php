<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->double('total');
            $table->string('notes');
            $table->date('date');

            $table->string('type');
            
            $table->foreignId('category_id');
            $table->foreignId('state_id');
            $table->foreignId('timing_id');
            $table->foreignId('method_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('timing_id')->references('id')->on('timings')->onDelete('cascade');
            $table->foreign('method_id')->references('id')->on('methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
