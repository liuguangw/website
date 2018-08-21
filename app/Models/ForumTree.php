<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 论坛结构关系模型
 * @package App\Models
 * @property int $id
 * @property int $parent_forum_id 上级论坛id
 * @property int $forum_id 论坛id
 * @property int tree_deep 结构深度
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class ForumTree extends Model
{
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['parent_forum_id', 'forum_id', 'tree_deep'];
}
