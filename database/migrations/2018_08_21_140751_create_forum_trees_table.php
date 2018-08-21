<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_trees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_forum_id')->comment('上级论坛id');
            $table->unsignedInteger('forum_id')->comment('论坛id');
            $table->unsignedInteger('tree_deep')->comment('深度');
            $table->timestamps();
            $table->unique(['parent_forum_id', 'forum_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_trees');
    }
}
