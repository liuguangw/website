<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_free')->default(false)->comment('是否已经提前解封');
            $table->unsignedInteger('free_user_id')->default(0)->comment('解封者id');
            $table->dateTime('end_time')->default(null)->nullable()->comment('结束时间');
            $table->dateTime('free_time')->default(null)->nullable()->comment('提前解封的操作时间');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('forum_id')->comment('论坛id');
            $table->unsignedInteger('admin_user_id')->comment('管理员id');
            $table->string('reason', 30)->default('')->comment('理由');
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
        Schema::dropIfExists('block_users');
    }
}
