<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/27
 * Time: 14:08
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 论坛帖子类别模型
 * @package App\Models
 * @property int $id 类别id
 * @property int $forum_id 所属论坛id
 * @property string $name 名称
 * @property string $color 颜色
 * @property int $post_count 帖子数量
 * @property int $order_id 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property Forum $forum 所属论坛
 */
class TopicType extends Model
{
    /**
     * 关联论坛
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
