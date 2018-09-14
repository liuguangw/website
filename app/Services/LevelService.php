<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/14
 * Time: 11:16
 */

namespace App\Services;


use App\Models\Level;
use Illuminate\Support\Facades\Cache;

/**
 * 用户等级计算
 * @package App\Services
 */
class LevelService
{
    private $cacheKey = 'levels';
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $allLevel;

    public function __construct()
    {
        $this->allLevel = Cache::remember($this->cacheKey, 600, function () {
            return Level::orderBy('min_exp')->get();
        });
    }

    /**
     * 清除等级数据缓存
     * @return void
     */
    public function clearCache()
    {
        Cache::forget($this->cacheKey);
    }

    /**
     * 获取所有的等级配置
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllLevel()
    {
        return $this->allLevel;
    }

    /**
     * 根据经验值计算等级
     * @param int $exp 经验值
     * @return Level
     */
    public function getLevel(int $exp): Level
    {
        return $this->allLevel->last(function ($value, $key) use ($exp) {
            return $exp >= $value->min_exp;
        });
    }

    /**
     * 根据当前经验值计算下一级别
     * @param int $exp 当前经验值
     * @return Level|null
     */
    public function getNextLevel(int $exp)
    {
        return $this->allLevel->firstWhere('min_exp', '>', $exp);
    }
}
