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
            $table->unsignedInteger('ref_count')->comment('引用计数')->default(1);
            $table->unsignedInteger('user_id')->comment('上传者用户id');
            $table->string('path')->comment('文件路径');
            $table->unsignedTinyInteger('region_type')->comment('用途类型: 1用户头像 2论坛图标 3帖子 4回复 5文章');
            $table->unsignedInteger('region_id')->comment('对应用途的id标识');
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
