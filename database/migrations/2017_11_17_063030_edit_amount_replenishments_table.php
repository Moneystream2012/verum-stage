<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAmountReplenishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replenishments', function (Blueprint $table) {
            $table->decimal('amount', 16, 4)->change();
            $table->decimal('cost_amount', 16, 4)->change();

            //$sql = "ALTER TABLE replenishments MODIFY cost_amount DOUBLE(8,4) NOT NULL DEFAULT '0.00';";
            //$sql2 = $sql."ALTER TABLE replenishments MODIFY amount DOUBLE(16,4) NOT NULL DEFAULT '0.00';";
            //DB::connection()->getPdo()->exec($sql2);
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
            //
        });
    }
}
