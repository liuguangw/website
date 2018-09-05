<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/22
 * Time: 12:14
 */

namespace App\Models;


use App\Traits\TimeFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * 帖子模型
 * @package App\Models
 * @property int $id 帖子id
 * @property int $forum_id 论坛id
 * @property int $user_id 作者用户id
 * @property int $reply_user_id 最后回复的用户id
 * @property int $topic_type_id 类别id
 * @property string $title 帖子标题
 * @property string $color 帖子颜色
 * @property int $view_count 阅读数
 * @property int $reply_count 回复数
 * @property int $like_count 支持数
 * @property int $notlike_count 反对数
 * @property int $order_id 排序
 * @property bool $t_disabled 是否被屏蔽
 * @property bool $t_locked 是否被锁定
 * @property bool $t_good 是否为精华帖
 * @property \Illuminate\Support\Carbon $post_time 帖子发布时间
 * @property \Illuminate\Support\Carbon $reply_time 帖子最后回复时间
 * @property \Illuminate\Support\Carbon $last_modify_time 帖子最后修改时间
 * @property \Illuminate\Support\Carbon $last_active_time 帖子最后活动时间
 * @property \Illuminate\Support\Carbon $deleted_at 帖子删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read bool $is_today_post 是否为今日发表的帖子
 * @property User $author 作者
 * @property User $lastReplyUser 最后的回复者
 * @property TopicType $topicType 帖子类别
 * @property TopicContent $topicContent 帖子内容
 * @property Forum $forum 所属论坛
 * @property \Illuminate\Database\Eloquent\Collection $replies 所有回复
 */
class Topic extends Model
{
    use SoftDeletes;
    use TimeFormatTrait;

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
        'reply_user_id' => 0,
        'color' => '',
        'view_count' => 0,
        'reply_count' => 0,
        'like_count' => 0,
        'notlike_count' => 0,
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

    /**
     * 最后回复者关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastReplyUser()
    {
        return $this->belongsTo(User::class, 'reply_user_id');
    }

    /**
     * 帖子类型关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topicType()
    {
        return $this->belongsTo(TopicType::class);
    }

    /**
     * 帖子内容关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function topicContent()
    {
        return $this->hasOne(TopicContent::class);
    }

    /**
     * 论坛关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    /**
     * 回复关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * 支持/反对关联(只有登录用户才能load)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function likeLog()
    {
        return $this->hasOne(PostLikeLog::class, 'post_id')
            ->where('post_type', PostLikeLog::TYPE_TOPIC)
            ->where('uid', Auth::id());
    }

    /**
     * 帖子链接
     * @param int $page 页码,默认1
     * @return string
     */
    public function link(int $page = 1)
    {
        if ($page = 1) {
            $page = '';
        }
        return action('TopicController@show', ['id' => $this->id, 'page' => $page]);
    }
}
