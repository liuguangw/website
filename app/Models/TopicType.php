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
 */
class TopicType extends Model
{
    /**
     * 关联论坛
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function forum()
    {
        return $this->hasOne(Forum::class);
    }
}
