<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 用户模型
 * @package App\Models
 * @property  int $id 用户id
 * @property string $username 用户名
 * @property string $password 加密过的密码
 * @property string $remember_token 记住密码token
 * @property string $nickname 用户昵称
 * @property int $sex 性别 0未知 1男 2女
 * @property-read string $sex_txt 性别文本
 * @property-read array $sex_array 所有性别配置数组
 * @property string $email email地址
 * @property bool $email_valid 邮箱是否已验证
 * @property bool $need_modify_password 是否需要修改密码
 * @property int $friend_count 好友数量
 * @property int $post_count 主题数量
 * @property int $reply_count 回帖数量
 * @property int $exp_count 经验值
 * @property int $coin_count 金币值
 * @property string $created_at 注册时间
 * @property string $updated_at 更新时间
 * @property string $deleted_at 删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read UploadFile avatarFile 头像文件
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
     * 定义类型转换
     *
     * @var array
     */
    protected $casts = [
        'email_valid' => 'boolean',
        'need_modify_password' => 'boolean'
    ];

    /**
     * 追加到模型数组表单的访问器.
     *
     * @var array
     */
    protected $appends = ['is_deleted', 'sex_txt'];

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
        'need_modify_password' => 0,
        'friend_count' => 0,
        'post_count' => 0,
        'reply_count' => 0,
        'exp_count' => 0,
        'coin_count' => 0,
        'deleted_at' => null
    ];

    public function avatarFile()
    {
        return $this->hasOne(UploadFile::class, 'region_id')->where(['region_type' => 1]);
    }

    public function getIsDeletedAttribute()
    {
        return $this->attributes['deleted_at'] !== null;
    }

    public function setIsDeletedAttribute(bool $value)
    {
        if ($value) {
            $this->attributes['deleted_at'] = now();
        } else {
            $this->attributes['deleted_at'] = null;
        }
    }

    public function getSexArrayAttribute()
    {
        return ['未知', '男', '女'];
    }

    public function getSexTxtAttribute()
    {
        return $this->sex_array[$this->sex];
    }
}
