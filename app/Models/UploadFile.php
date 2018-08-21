<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 上传的文件
 * @package App\models
 * @property int $id 文件id
 */
class UploadFile extends Model
{
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['ref_count', 'user_id', 'path', 'file_size', 'extension', 'region_type', 'region_id'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'ref_count' => 1
    ];
}
