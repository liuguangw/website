<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/21
 * Time: 14:29
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 论坛模型
 * @package App\Models
 * @property int $id 论坛id
 * @property int $forum_group_id 所属分区id
 * @property string $name 名称
 * @property string $color 颜色
 * @property string $description 班规
 * @property int $post_count 主题总数
 * @property int $reply_count 回帖总数
 * @property int $today_post_count 今日主题数
 * @property int $today_reply_count 今日回帖数
 * @property string $today_updated_at 今日统计数据更新时间
 * @property bool $is_root 是否为顶级论坛
 * @property int $order_id 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read ForumGroup $forumGroup 论坛对应的分区
 * @property-read \Illuminate\Database\Eloquent\Collection $parentForums 上级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $childForums 直接下级级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $allChildForums 所有下级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $topics 主题列表
 * @property-read UploadFile $avatarFile 图标文件
 * @property-read string $avatar_url 论坛图标url
 * @property \Illuminate\Database\Eloquent\Collection $topicTypes 论坛所有帖子类型
 */
class Forum extends Model
{
    use SoftDeletes;

    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'today_updated_at'];

    /**
     * 定义类型转换
     *
     * @var array
     */
    protected $casts = [
        'is_root' => 'boolean'
    ];

    /**
     * 追加到模型数组表单的访问器.
     *
     * @var array
     */
    protected $appends = ['is_deleted', 'avatar_url'];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'order_id', 'today_updated_at'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'description' => '',
        'post_count' => 0,
        'reply_count' => 0,
        'today_post_count' => 0,
        'today_reply_count' => 0,
        'order_id' => 0,
        'deleted_at' => null,
        'today_updated_at' => null
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

    public function getAvatarUrlAttribute()
    {
        if ($this->avatarFile === null) {
            return asset('images/default/forum_avatar.png');
        }
        return $this->avatarFile->url;
    }

    /**
     * 所属分区
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forumGroup()
    {
        return $this->belongsTo(ForumGroup::class);
    }

    /**
     * 图标文件关联
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function avatarFile()
    {
        return $this->hasOne(UploadFile::class, 'region_id')->where(['region_type' => 2]);
    }

    /**
     * 所有上级论坛
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parentForums()
    {
        return $this->belongsToMany(Forum::class, 'forum_trees', 'forum_id', 'parent_forum_id')
            ->where('forum_trees.tree_deep', '>', 0)
            ->orderByDesc('forum_trees.tree_deep');
    }

    /**
     * 直接下级论坛
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childForums()
    {

        return $this->belongsToMany(Forum::class, 'forum_trees', 'parent_forum_id', 'forum_id')
            ->where('forum_trees.tree_deep', '=', 1)
            ->orderByDesc('forums.order_id')
            ->orderBy('forums.id');
    }

    /**
     * 所有下级论坛
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allChildForums()
    {

        return $this->belongsToMany(Forum::class, 'forum_trees', 'parent_forum_id', 'forum_id')
            ->where('forum_trees.tree_deep', '>', 0)
            ->orderByDesc('forum_trees.tree_deep')
            ->orderByDesc('forums.order_id')
            ->orderBy('forums.id');
    }

    /**
     * 主题列表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * 帖子类型关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topicTypes()
    {
        return $this->hasMany(TopicType::class);
    }

    /**链接
     * @param array $params
     * @return string
     */
    public function link(array $params = [])
    {
        return route('forum', array_merge(
                [
                    'id' => $this->id,
                    'type' => 'all',
                    'filter' => 'all',
                    'order' => 'common',
                    'page' => 1
                ],
                $params)
        );
    }

    /**
     * 发表帖子url
     * @return string
     */
    public function createTopicLink()
    {
        return action('TopicController@create', ['id' => $this->id]);
    }

    /**
     * 更新今日统计数据
     * @return void
     */
    public function updateTodayData()
    {
        $beginTime = today();
        $this->today_post_count = Topic::where('forum_id', $this->id)->where('post_time', '>', $beginTime)->count();
        $this->today_reply_count = Reply::query()->leftJoin('topic', 'replies.topic_id', '=', 'topic.id')->where('topic.forum_id', $this->id)->count();
        $this->today_updated_at = now();
        $this->save();
    }

    /**
     * 处理论坛新帖发表记录
     * @return void
     */
    public function onNewPost()
    {
        $this->increment('post_count');
        if ($this->today_updated_at->lt(today())) {
            $this->updateTodayData();
        }
        $this->increment('today_post_count');
    }

    /**
     * 处理论坛新的回复
     * @return void
     */
    public function onNewReply()
    {
        $this->increment('reply_count');
        if ($this->today_updated_at->lt(today())) {
            $this->updateTodayData();
        }
        $this->increment('today_reply_count');
    }
}
