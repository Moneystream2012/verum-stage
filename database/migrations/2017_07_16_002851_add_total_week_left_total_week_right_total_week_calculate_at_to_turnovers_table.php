<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalWeekLeftTotalWeekRightTotalWeekCalculateAtToTurnoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turnovers', function (Blueprint $table) {
            $table->double('total_week_left', 16, 2)->default(0.00);
            $table->double('total_week_right', 16, 2)->default(0.00);
            $table->double('total_week', 16, 2)->default(0.00);
            $table->timestamp('calculate_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('turnovers', function (Blueprint $table) {
            $table->dropColumn(['total_week_left', 'total_week_right', 'total_week', 'calculate_at']);
        });
    }
}
