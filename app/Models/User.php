<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 用户模型
 * Class User
 * @package App\Models
 * @property  int $id 用户id
 * @property UploadFile avatarFile 头像文件
 * @property string $password 加密过的密码
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
        'email_valid' => 0,
        'need_reset_password' => 0,
        'deleted_at' => null
    ];

    public function avatarFile()
    {
        return $this->hasOne('App\Models\UploadFile', 'region_id')->where(['region_type' => 1]);
    }
}
