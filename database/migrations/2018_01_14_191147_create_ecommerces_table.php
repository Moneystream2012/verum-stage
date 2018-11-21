<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecommerces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('replenishment_id')->unsigned();
            $table->foreign('replenishment_id')->references('id')
                ->on('replenishments')->onDelete('cascade');
            $table->string('txid', 64)->index();
            $table->string('category', 10);
            $table->string('address', 34);
            $table->double('amountUSD', 11, 2)->default(0.00);
            $table->double('amountVMC', 11, 4)->default(0.0000);
            $table->boolean('paid')->default(false);
            $table->integer('confirmations')->default(0);
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
        Schema::dropIfExists('ecommerces');
    }
}
