<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTurnover2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnover2s', function (Blueprint $table) {
            $table->timestamp('calculate_at')->nullable();
            $table->dropColumn(['binary_total']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turnover2s', function (Blueprint $table) {
            $table->dropColumn(['calculate_at']);
        });
    }
}
