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
 * 论坛分区模型
 * @package App\Models
 * @property int $id 分区id
 * @property string $name 名称
 * @property int $order_id 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon $deleted_at 删除时间
 * @property bool $is_deleted 是否标记为已删除
 * @property-read \Illuminate\Database\Eloquent\Collection $childForums 直接子论坛列表
 * @property-read \Illuminate\Database\Eloquent\Collection $allChildForums 所有子论坛列表
 */
class ForumGroup extends Model
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
    protected $fillable = ['name', 'order_id'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'order_id' => 0,
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

    /**
     * 直接子论坛关联
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childForums()
    {
        return $this->hasMany(Forum::class)->where(['is_root' => 1]);
    }

    /**
     * 所有子论坛关联
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allChildForums()
    {
        return $this->hasMany(Forum::class);
    }


    /**链接
     * @param array $params
     * @return string
     */
    public function link(array $params = [])
    {
        return route('forumGroup', array_merge(['id' => $this->id], $params));
    }
}
