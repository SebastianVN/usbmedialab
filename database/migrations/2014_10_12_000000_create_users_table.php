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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('level')->default(1);
            $table->tinyInteger('confirmed')->default(0);
            $table->string('random')->nullable();
            $table->dateTime('last_confirmation_sent')->nullable()->useCurrent();
            $table->integer('fail_login')->default(0);
            $table->integer('total_fail_login')->default(0);
            $table->dateTime('last_fail_login')->nullable();
            $table->enum('status',['active','blocked','suspect'])->default('active');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
