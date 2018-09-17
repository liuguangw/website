<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/17
 * Time: 11:03
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 论坛规则属性
 * @package App\Models
 * @property int $forum_id 论坛id
 * @property string $meta_item_key 属性键名
 * @property string $meta_item_value 属性值
 * @property-read string $description 描述
 * @property Forum $forum 关联论坛
 */
class ForumMeta extends Model
{
    /**
     * 属性描述
     */
    const META_DESCRIPTIONS = [
        // 默认金币、经验规则
        'post_topic.coin' => '发表主题帖奖励金币',
        'post_topic.exp' => '发表主题帖奖励经验',

        'post_reply.coin' => '发表回帖奖励金币',
        'post_reply.exp' => '发表回帖奖励经验',

        'top_topic.coin' => '顶置帖子奖励金币',
        'top_topic.exp' => '顶置帖子奖励经验',

        'untop_topic.clear_coin' => '取消顶置帖子时回收金币',
        'untop_topic.clear_exp' => '取消顶置帖子时回收经验',

        'good_topic.coin' => '精华帖子奖励金币',
        'good_topic.exp' => '精华帖子奖励经验',

        'ungood_topic.clear_coin' => '取消精华帖子时回收金币',
        'ungood_topic.clear_exp' => '取消精华帖子时回收经验',

        'lock_topic.clear_coin' => '锁定帖子清除金币',
        'lock_topic.clear_exp' => '锁定帖子清除经验',

        'unlock_topic.coin' => '解锁帖子时返还金币',
        'unlock_topic.exp' => '解锁帖子时返还经验',

        'block_topic.clear_coin' => '屏蔽帖子清除金币',
        'block_topic.clear_exp' => '屏蔽帖子清除经验',

        'unblock_topic.coin' => '取消屏蔽帖子时返还金币',
        'unblock_topic.exp' => '取消屏蔽帖子时返还经验',

        'delete_topic.clear_coin' => '删除帖子清除金币',
        'delete_topic.clear_exp' => '删除帖子清除经验',

        'undelete_topic.coin' => '恢复删除的帖子时返还金币',
        'undelete_topic.exp' => '恢复删除的帖子时返还经验',

        'block_reply.clear_coin' => '屏蔽回帖清除金币',
        'block_reply.clear_exp' => '屏蔽回帖清除经验',

        'unblock_reply.coin' => '取消屏蔽回帖时返还金币',
        'unblock_reply.exp' => '取消屏蔽回帖时返还经验',

        'delete_reply.clear_coin' => '删除回帖清除金币',
        'delete_reply.clear_exp' => '删除回帖清除经验',

        'undelete_reply.coin' => '恢复删除的回帖时返还金币',
        'undelete_reply.exp' => '恢复删除的回帖时返还经验',
        //等级限制
        'min_level.post_topic' => '发表帖子的最低等级',
        'min_level.post_reply' => '发表回帖的最低等级',
        'min_level.view_forum' => '查看论坛的最低等级',
        'min_level.view_topic' => '查看帖子的最低等级',
        'min_level.view_reply' => '查看回帖的最低等级',
        //游客限制
        'guest.can_view_forum' => '游客是否能查看论坛',
        'guest.can_view_topic' => '游客是否能查看帖子',
        'guest.can_view_reply' => '游客是否能查看回帖',
        // 黑名单发言限制
        'block_user.can_post_topic' => '此论坛被屏蔽的用户能否发表帖子',
        'block_user.can_post_reply' => '此论坛被屏蔽的用户能否发表回帖'
    ];
    /**
     * 非自增主键
     * @var bool
     */
    public $incrementing = false;
    protected $primaryKey = ['forum_id', 'meta_item_key'];
    public $timestamps = false;
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['meta_item_value'];

    /**
     * 追加到模型数组表单的访问器.
     *
     * @var array
     */
    protected $appends = ['description'];


    public function getDescriptionAttribute()
    {
        return self::META_DESCRIPTIONS[$this->meta_item_key];
    }

    /**
     * 论坛关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getForum()
    {
        return $this->belongsTo(Forum::class);
    }
}
