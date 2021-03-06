<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/21
 * Time: 14:29
 */

namespace App\Models;


use App\Services\ForumConfigService;
use App\Traits\TimeFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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
 * @property int $last_post_type 最后发布的类型 0空 1主题 2回复
 * @property \Illuminate\Support\Carbon $last_post_time 最后发布的时间
 * @property int $last_post_user_id 最后发布的用户id
 * @property int $last_topic_id 最后活动的主题id
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read ForumGroup $forumGroup 论坛对应的分区
 * @property-read \Illuminate\Database\Eloquent\Collection $parentForums 上级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $childForums 直接下级级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $allChildForums 所有下级论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $metas 规则属性列表
 * @property-read \Illuminate\Database\Eloquent\Collection $result_metas 经过计算得到的最终属性规则列表
 * @property-read \Illuminate\Database\Eloquent\Collection $topics 主题列表
 * @property-read \Illuminate\Database\Eloquent\Collection $blockUsers 论坛黑名单列表
 * @property-read UploadFile $avatarFile 图标文件
 * @property-read string $avatar_url 论坛图标url
 * @property \Illuminate\Database\Eloquent\Collection $topicTypes 论坛所有帖子类型
 * @property User $lastPostUser 最后的发布用户
 * @property Topic $lastTopic 最后活动的主题
 */
class Forum extends Model
{
    use SoftDeletes;
    use TimeFormatTrait;

    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'today_updated_at', 'last_post_time'];

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
        'last_post_type' => 0,
        'last_post_time' => null,
        'last_post_user_id' => 0,
        'last_topic_id' => 0,
        'deleted_at' => null,
        'today_updated_at' => null
    ];

    private $cachedMetas = null;

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
     * 论坛规则属性关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metas()
    {
        return $this->hasMany(ForumMeta::class);
    }

    public function getResultMetasAttribute()
    {
        if ($this->metas->isNotEmpty()) {
            return $this->metas;
        }
        if (!$this->is_root) {
            $parentForums = $this->parentForums->load('metas')->reverse();
            foreach ($parentForums as $forum) {
                if ($forum->metas->isNotEmpty()) {
                    return $forum->metas;
                }
            }
        }
        //返回默认值
        $metaKeys = array_keys(ForumMeta::META_DESCRIPTIONS);
        /**
         * @var ForumConfigService $forumConfigService
         */
        $forumConfigService = resolve(ForumConfigService::class);
        $config = $forumConfigService->getMuti($metaKeys);
        $result = collect();
        foreach ($metaKeys as $metaItemKey) {
            $tempMeta = new ForumMeta();
            $tempMeta->setRawAttributes([
                'forum_id' => $this->id,
                'meta_item_key' => $metaItemKey,
                'meta_item_value' => $config->get($metaItemKey, '')
            ]);
            $result->push($tempMeta);
        }
        return $result;
    }

    /**
     * 获取规则属性值
     * @param string $metaItemKey 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function getMetaValue(string $metaItemKey, $default = null)
    {
        if ($this->cachedMetas === null) {
            $this->cachedMetas = $this->result_metas;
        }
        /**
         * @var ForumMeta|null $result
         */
        $result = $this->cachedMetas->firstWhere('meta_item_key', '=', $metaItemKey);
        if ($result === null) {
            return $default;
        } else {
            return $result->meta_item_value;
        }
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

    /**
     * 最后发布的用户关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastPostUser()
    {
        return $this->belongsTo(User::class, 'last_post_user_id');
    }

    /**
     * 最后活动的主帖关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastTopic()
    {
        return $this->belongsTo(Topic::class, 'last_topic_id');
    }

    /**
     * 当前论坛黑名单列表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockUsers()
    {
        return $this->hasMany(BlockUser::class)->where('is_free', 0)->where(function (Builder $query) {
            $query->whereNull('end_time')->orWhere('end_time', '>', now()->toDateTimeString());
        });
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
                    'page' => ''
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
        $this->today_reply_count = Reply::query()->leftJoin('topics', 'replies.topic_id', '=', 'topics.id')->where('topics.forum_id', $this->id)->count();
        $this->today_updated_at = now();
        $this->save();
    }

    /**
     * 处理论坛新帖发表记录
     * @param Topic $topic
     * @return void
     */
    public function onNewPost(Topic $topic)
    {
        $this->increment('post_count');
        if ($this->today_updated_at->lt(today())) {
            $this->updateTodayData();
        }
        $this->increment('today_post_count');
        $this->procNewPost($topic->user_id, $topic->id, 1);
        //根据规则增加金币、经验
        $author = $topic->author;
        $addCoin = $this->getMetaValue('post_topic.coin', 0);
        $addExp = $this->getMetaValue('post_topic.exp', 0);
        if ($addCoin > 0) {
            $author->increment('coin_count', $addCoin);
        }
        if ($addExp > 0) {
            $author->increment('exp_count', $addExp);
        }
    }

    /**
     * 处理论坛新的回复
     * @param Reply $reply
     * @return void
     */
    public function onNewReply(Reply $reply)
    {
        $this->increment('reply_count');
        if ($this->today_updated_at->lt(today())) {
            $this->updateTodayData();
        }
        $this->increment('today_reply_count');
        $this->procNewPost($reply->user_id, $reply->topic_id, 2);
        //根据规则增加金币、经验
        $author = $reply->author;
        $addCoin = $this->getMetaValue('post_reply.coin', 0);
        $addExp = $this->getMetaValue('post_reply.exp', 0);
        if ($addCoin > 0) {
            $author->increment('coin_count', $addCoin);
        }
        if ($addExp > 0) {
            $author->increment('exp_count', $addExp);
        }
    }

    /**
     * 记录论坛最新活动的主帖
     * @param int $userId 用户id
     * @param int $topicId 主帖id
     * @param int $postType 类型 0空 1主题 2回复
     * @return void
     */
    private function procNewPost(int $userId, int $topicId, int $postType)
    {
        $this->last_post_user_id = $userId;
        $this->last_post_type = $postType;
        $this->last_topic_id = $topicId;
        $this->last_post_time = now();
        $this->save();
    }
}
