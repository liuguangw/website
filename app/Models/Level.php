<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/12
 * Time: 16:11
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Services\LevelService;

/**
 * 用户等级
 * @package App\Models
 * @property int $id 等级id
 * @property string $name 名称
 * @property string $description 描述信息
 * @property int $min_exp 此等级的经验值上限
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read Level|null $next_level 下一级别
 */
class Level extends Model
{
    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'min_exp'];

    /**
     * 初始值
     *
     * @var array
     */
    protected $attributes = [
        'description' => ''
    ];

    public function getNextLevelAttribute()
    {
        /**
         * @var LevelService $levelService
         */
        $levelService = resolve(LevelService::class);
        return $levelService->getNextLevel($this->min_exp);
    }
}
