<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->morphs('support');
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::create('issue_dialogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('issue_id')->unsigned();
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
            $table->boolean('is_support')->default(false);
            $table->boolean('read')->default(false);
            $table->text('body');
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
        Schema::dropIfExists('issues');
        Schema::dropIfExists('issue_dialogs');
    }
}
