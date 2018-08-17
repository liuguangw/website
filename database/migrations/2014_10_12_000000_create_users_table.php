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
            $table->string('username', 14)->comment('用户名')->unique();
            $table->string('password')->comment('密码');
            $table->rememberToken();
            $table->string('nickname', 16)->comment('昵称');
            $table->unsignedTinyInteger('sex')->comment('性别 0未知 1男 2女')->default(0);
            $table->string('email')->comment('email地址')->unique();
            $table->boolean('email_valid')->comment('email是否已验证')->default(false);
            $table->boolean('need_reset_password')->comment('是否需要重置密码')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
