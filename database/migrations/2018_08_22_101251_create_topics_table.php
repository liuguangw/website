<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id')->comment('所属论坛id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('reply_user_id')->default(0)->comment('最后回复的用户id');
            $table->unsignedInteger('topic_type_id')->comment('类别id');
            $table->string('title', 30)->comment('帖子标题');
            $table->string('color', 12)->default('')->comment('颜色');
            $table->unsignedInteger('view_count')->default(0)->comment('阅读数');
            $table->unsignedInteger('reply_count')->default(0)->comment('回复数');
            $table->unsignedInteger('like_count')->default(0)->comment('支持数');
            $table->unsignedInteger('notlike_count')->default(0)->comment('反对数');
            $table->unsignedInteger('order_id')->default(1)->comment('排序');
            $table->boolean('t_disabled')->default(false)->comment('是否被屏蔽');
            $table->boolean('t_locked')->default(false)->comment('是否被锁定');
            $table->boolean('t_good')->default(false)->comment('是否为精华帖');
            $table->timestamp('post_time')->nullable()->comment('帖子发布时间');
            $table->timestamp('reply_time')->nullable()->comment('帖子回复时间');
            $table->timestamp('last_modify_time')->nullable()->comment('帖子最后修改时间');
            $table->timestamp('last_active_time')->nullable()->comment('帖子最后活动时间');
            $table->softDeletes();
            $table->index(['forum_id']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
