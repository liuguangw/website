<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_metas', function (Blueprint $table) {
            $table->unsignedInteger('forum_id')->comment('论坛id');
            $table->string('meta_item_key', 30)->comment('配置键');
            $table->string('meta_item_value')->comment('配置值');
            $table->primary(['forum_id', 'meta_item_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_metas');
    }
}
