<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('topic_id')->comment('帖子id');
            $table->unsignedInteger('floor_id')->comment('楼层');
            $table->unsignedInteger('to_floor_id')->comment('回复的楼层');
            $table->unsignedInteger('user_id')->comment('回帖用户id');
            $table->string('content', 800)->comment('内容');
            $table->boolean('t_disabled')->default(false)->comment('是否被屏蔽');
            $table->unsignedInteger('like_count')->default(0)->comment('支持数');
            $table->unsignedInteger('notlike_count')->default(0)->comment('反对数');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['topic_id', 'floor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
