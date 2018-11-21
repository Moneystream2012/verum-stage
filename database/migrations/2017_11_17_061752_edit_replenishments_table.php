<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditReplenishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replenishments', function (Blueprint $table) {
            $table->enum('currency', ['USD', 'BTC', 'VMC'])->default('USD');
            $table->renameColumn("`amountUSD`", 'amount');
            $table->dropColumn(['amountVMC']);
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
            $table->dropColumn(['currency']);
        });
    }
}
