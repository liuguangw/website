<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id')->comment('所属论坛id');
            $table->string('name', 18)->comment('类别名称');
            $table->string('color', 12)->default('')->comment('颜色');
            $table->unsignedInteger('post_count')->default(0)->comment('帖子数量');
            $table->unsignedInteger('order_id')->default(0)->comment('排序');
            $table->timestamps();
            $table->index(['forum_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_types');
    }
}
