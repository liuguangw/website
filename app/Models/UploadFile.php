<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 上传的文件
 * @package App\models
 * @property int $id 文件id
 * @property string $path 保存路径
 * @property-read string $url 文件url
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

    /**
     * 获取文件url地址
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->path;
    }
}
