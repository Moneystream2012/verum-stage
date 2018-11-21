<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 60)->unique();
            $table->tinyInteger('plan')->default(0);
            $table->string('address', 34)->nullable();
            $table->double('balance', 11, 4)->default(0.0000);
            $table->integer('sponsor_id')->index();
            $table->boolean('leg');
            $table->boolean('side_leg');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('mobile_number')->unique();
            $table->char('country', 2);
            $table->string('avatar', 20)->nullable();
            $table->string('password');
            $table->string('transaction_password')->nullable();
            $table->boolean('verified_email')->default(false);
            $table->string('token_email')->nullable();
            $table->text('settings')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('active_at')->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
