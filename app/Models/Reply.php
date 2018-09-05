<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 14:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * 帖子回复模型
 * @package App\Models
 * @property int $id 回复id
 * @property int $topic_id 帖子id
 * @property int $floor_id 楼层
 * @property int $to_floor_id 回复的楼层
 * @property int $user_id 用户id
 * @property string $content 回复内容
 * @property bool $t_disabled 是否被屏蔽
 * @property int $like_count 支持数
 * @property int $notlike_count 反对数
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 * @property Topic $topic 所属帖子
 * @property User $author 所属用户
 */
class Reply extends Model
{
    use SoftDeletes;
    /**
     * 需要转换成日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * 追加到模型数组表单的访问器.
     *
     * @var array
     */
    protected $appends = ['is_deleted'];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['to_floor_id', 'content'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'to_floor_id' => 0,
        't_disabled' => 0,
        'like_count' => 0,
        'notlike_count' => 0,
        'deleted_at' => null
    ];

    /**
     * 定义类型转换
     *
     * @var array
     */
    protected $casts = [
        't_disabled' => 'boolean'
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

    /**
     * 帖子关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * 用户关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
