<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_configs', function (Blueprint $table) {
            $table->string('item_key', 30)->comment('配置键');
            $table->string('description', 30)->default('')->comment('配置说明');
            $table->string('item_value')->comment('配置值');
            $table->primary('item_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_configs');
    }
}
