<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->string('from', 60);
            $table->string('to', 60);
            $table->float('point_left');
            $table->float('point_right');
            $table->float('reward');
            $table->float('amount');
            $table->tinyInteger('plan');
            $table->tinyInteger('status');
            $table->tinyInteger('number_of');
            $table->timestamp('computed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computes');
    }
}
