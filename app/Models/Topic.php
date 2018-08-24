<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/22
 * Time: 12:14
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 帖子模型
 * @package App\Models
 * @property int $id 帖子id
 * @property int $forum_id 论坛id
 * @property int $user_id 作者用户id
 * @property int $forum_type_id 类别id
 * @property string $title 帖子标题
 * @property string $color 帖子颜色
 * @property int $view_count 阅读数
 * @property int $reply_count 回复数
 * @property int $order_id 排序
 * @property bool $t_disabled 是否被屏蔽
 * @property bool $t_locked 是否被锁定
 * @property bool $t_good 是否为精华帖
 * @property string $post_time 帖子发布时间
 * @property string $reply_time 帖子最后回复时间
 * @property string $last_modify_time 帖子最后修改时间
 * @property string $last_active_time 帖子最后活动时间
 * @property string $deleted_at 帖子删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read bool $is_today_post 是否为今日发表的帖子
 * @property User $author 作者
 */
class Topic extends Model
{
    use SoftDeletes;

    /**
     * 不使用默认时间配置
     * @var bool
     */
    public $timestamps = false;

    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['post_time', 'reply_time', 'last_modify_time', 'last_active_time', 'deleted_at'];

    /**
     * 定义类型转换
     *
     * @var array
     */
    protected $casts = [
        't_disabled' => 'boolean',
        't_locked' => 'boolean',
        't_good' => 'boolean'
    ];

    /**
     * 追加到模型数组表单的访问器.
     *
     * @var array
     */
    protected $appends = ['is_deleted', 'is_today_post'];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'color' => '',
        'view_count' => 0,
        'reply_count' => 0,
        'order_id' => 1,
        't_disabled' => 0,
        't_locked' => 0,
        't_good' => 0,
        'reply_time' => null,
        'last_modify_time' => null,
        'deleted_at' => null
    ];


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

    public function getIsTodayPostAttribute()
    {
        $createdTime = strtotime($this->post_time);
        $t1 = strtotime(date('Y-m-d'));
        return $createdTime >= $t1;
    }

    /**
     * 作者关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
