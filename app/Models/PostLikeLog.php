<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/4
 * Time: 16:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 发布的支持/反对记录
 * @package App\Models
 * @property int $id
 * @property int $uid 用户id
 * @property int $post_type 发布类型 1主题 2回复
 * @property int $post_id 发布的id
 * @property boolean $is_like 是否支持
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 */
class PostLikeLog extends Model
{
    /**
     * 主题
     */
    const TYPE_TOPIC = 1;
    /**
     * 回复
     */
    const TYPE_REPLY = 2;
    /**
     * 定义类型转换
     *
     * @var array
     */
    protected $casts = [
        'is_like' => 'boolean'
    ];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['post_id','post_type','is_like'];
}
