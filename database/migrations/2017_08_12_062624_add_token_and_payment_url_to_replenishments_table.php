<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenAndPaymentUrlToReplenishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replenishments', function (Blueprint $table) {
            $table->string('token', 16)->nullable();
            $table->string('payment_url', 100)->nullable();
            $table->integer('payment_id')->nullable();
            $table->string('status', 16)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replenishments', function (Blueprint $table) {
            $table->dropColumn(['token', 'payment_url', 'payment_id']);
        });
    }
}
