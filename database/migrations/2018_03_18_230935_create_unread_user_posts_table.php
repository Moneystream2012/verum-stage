<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnreadUserPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unread_user_posts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->tinyInteger('unread')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unread_user_posts');
    }
}
