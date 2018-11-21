<?php

use App\Trading;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tradings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->float('invest')->default(0);
            $table->float('profit')->default(0);
            $table->tinyInteger('number_of')->default(0);
            $table->timestamp('calculate_at');
            $table->timestamp('created_at');
            $table->timestamp('final_at');
            $table->enum('status', [
                Trading::ACTIVE,
                Trading::FINAL,
                Trading::REFUND,
            ])->default(Trading::ACTIVE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tradings');
    }
}
