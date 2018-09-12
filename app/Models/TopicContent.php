<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 10:24
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 帖子内容关联
 * @package App\Models
 * @property int $id 记录id
 * @property int $topic_id 帖子id
 * @property string $content 内容
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property Topic $topic 所属帖子
 */
class TopicContent extends Model
{
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * 帖子关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
