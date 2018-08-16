<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 用户模型
 * Class User
 * @package App\Models
 * @property UploadFile avatarFile 头像文件
 */
class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'nickname', 'sex', 'email'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'sex' => 0,
        'avatar_file_id' => 0,
        'email_valid' => 0,
        'deleted_at' => null
    ];

    public function avatarFile()
    {
        return $this->belongsTo('App\Models\UploadFile', 'avatar_file_id');
    }
}
