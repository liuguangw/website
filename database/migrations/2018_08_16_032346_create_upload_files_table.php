<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ref_count')->comment('引用计数')->default(0);
            $table->unsignedInteger('user_id')->comment('上传者用户id')->default(0);
            $table->string('path')->comment('文件路径');
            $table->unsignedInteger('file_size')->comment('文件大小');
            $table->string('extension', 12)->comment('文件后缀');
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
        Schema::dropIfExists('upload_files');
    }
}
