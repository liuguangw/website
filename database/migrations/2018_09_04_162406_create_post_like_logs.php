<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostLikeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_like_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('uid')->comment('用户id');
            $table->unsignedTinyInteger('post_type')->comment('发布的类型: 1主题 2回复');
            $table->unsignedInteger('post_id')->comment('发布的id');
            $table->boolean('is_like')->comment('是否为支持');
            $table->unique(['uid', 'post_type', 'post_id']);
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
        Schema::dropIfExists('post_like_logs');
    }
}
