<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddMiningBalanceToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->double('mining_balance', 11, 2)->default(0.00);
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('mining_balance');
        });
    }
}
