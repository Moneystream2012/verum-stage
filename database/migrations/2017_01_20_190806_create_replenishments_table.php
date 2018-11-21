<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplenishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replenishments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->string('method', 60);
            $table->string('to', 60);
            $table->float('cost_amount')->default(0);
            $table->double('amountUSD', 11, 2)->default(0.00);
            $table->double('amountVMC', 11, 4)->default(0.0000);
            $table->string('status', 60)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('done_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replenishments');
    }
}
