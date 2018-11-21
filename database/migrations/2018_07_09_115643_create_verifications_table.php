<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number')->unique();
            $table->string('email')->unique();
            $table->char('country', 2);
            $table->string('doc_img', 20)->nullable();
            $table->string('avatar', 20)->nullable();
            $table->enum('status', [
                '1',
                '2',
            ])->default(\App\Verification::PROCESSING);
            $table->timestamp('verification_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifications');
    }
}
