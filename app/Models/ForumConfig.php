<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/14
 * Time: 14:31
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 论坛配置
 * @package App\Models
 * @property string $item_key 配置键
 * @property string $description 配置说明
 * @property string $item_value 配置值
 */
class ForumConfig extends Model
{
    /**
     * 非自增主键
     * @var bool
     */
    public $incrementing = false;

    protected $keyType = 'string';
    protected $primaryKey = 'item_key';
    public $timestamps = false;
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['item_value', 'description'];
}
