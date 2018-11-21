<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('plan');
            $table->tinyInteger('number_of')->default(0);
            $table->float('profit')->default(0);
            $table->float('withdrawal_amount')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamp('withdrawal_at')->nullable();
            $table->timestamp('calculate_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('final_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
