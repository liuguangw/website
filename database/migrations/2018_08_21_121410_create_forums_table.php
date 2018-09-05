<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_group_id')->comment('分区id');
            $table->string('name', 18)->comment('名称');
            $table->string('color', 12)->default('')->comment('颜色');
            $table->text('description')->comment('版规');
            $table->unsignedInteger('post_count')->comment('主题总数')->default(0);
            $table->unsignedInteger('reply_count')->comment('回帖总数')->default(0);
            $table->unsignedInteger('today_post_count')->comment('今日主题总数')->default(0);
            $table->unsignedInteger('today_reply_count')->comment('今日回帖总数')->default(0);
            $table->timestamp('today_updated_at')->comment('今日统计数据更新时间')->nullable();
            $table->boolean('is_root')->comment('是否为顶级论坛')->default(true);
            $table->unsignedInteger('order_id')->comment('排序')->default(0);
            $table->unsignedTinyInteger('last_post_type')->default(0)->comment('最后发布的类型 0空 1主题 2回复');
            $table->timestamp('last_post_time')->comment('最后发帖/回帖时间')->nullable();
            $table->unsignedInteger('last_post_user_id')->default(0)->comment('最后发布的用户id');
            $table->unsignedInteger('last_topic_id')->default(0)->comment('最后活动的主帖id');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['forum_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forums');
    }
}
