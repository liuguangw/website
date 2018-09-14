<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/14
 * Time: 14:44
 */

namespace App\Services;


use App\Models\ForumConfig;
use Illuminate\Support\Facades\Cache;

class ForumConfigService
{
    /**
     * 临时缓存
     * @var \Illuminate\Support\Collection
     */
    private $config;
    /**
     * 新缓存过期时间
     * @var \Illuminate\Support\Carbon
     */
    private $cacheExpiredTime;

    public function __construct()
    {
        $this->config = collect();
        //数据缓存10小时
        $this->cacheExpiredTime = now()->addHours(10);
    }

    /**
     * 预加载数据
     * @param array $keys 需要获取的键名数组
     * @return $this
     */
    public function load(array $keys)
    {
        $needKeys = [];
        foreach ($keys as $keyName) {
            if (!$this->config->has($keyName)) {
                $itemCacheKey = $this->getItemCacheKey($keyName);
                // 判断缓存中是否有此数据
                if (Cache::has($itemCacheKey)) {
                    $this->config->put($keyName, Cache::get($itemCacheKey));
                } else {
                    $needKeys[] = $keyName;
                }
            }
        }
        if (!empty($needKeys)) {
            // 从数据库加载缓存中不存在的数据
            $items = ForumConfig::find($keys);
            foreach ($items as $temp) {
                // 数据缓存10小时
                Cache::put($this->getItemCacheKey($temp->item_key), $temp->item_value, $this->cacheExpiredTime);
                $this->config->put($temp->item_key, $temp->item_value);
            }
        }
        return $this;
    }

    /**
     * 获取配置对应的缓存键名
     * @param string $itemKey
     * @return string
     */
    private function getItemCacheKey(string $itemKey)
    {
        return 'config.' . $itemKey;
    }

    /**
     * 读取单个值
     * @param string $itemKey 键名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get(string $itemKey, $default = null)
    {
        if (!$this->config->has($itemKey)) {
            $itemCacheKey = $this->getItemCacheKey($itemKey);
            if (Cache::has($itemCacheKey)) {
                $this->config->put($itemKey, Cache::get($itemCacheKey));
            } else {
                $item = ForumConfig::find($itemKey);
                if ($item !== null) {
                    Cache::put($itemCacheKey, $item, $this->cacheExpiredTime);
                    $this->config->put($itemKey, $item);
                }

            }
        }
        return $this->config->get($itemKey, $default);
    }

    /**
     * 读取多个值
     * @param array $keys 键数组
     * @return \Illuminate\Support\Collection
     */
    public function getMuti(array $keys)
    {
        $this->load($keys);
        return $this->config->only($keys);
    }

    /**
     * 设置论坛配置
     * @param string $itemKey
     * @param string $itemValue
     * @return void
     */
    public function set(string $itemKey, string $itemValue)
    {
        /**
         * @var ForumConfig $item
         */
        $item = ForumConfig::firstOrNew([
            'item_key' => $itemKey
        ]);
        $item->item_value = $itemValue;
        $item->save();
        $this->config->put($itemKey, $itemValue);
        Cache::put($this->getItemCacheKey($itemKey), $itemValue, $this->cacheExpiredTime);
    }

    /**
     * 批量设置配置
     * @param array $configArr 配置键值映射
     * @return void
     */
    public function setMuti(array & $configArr)
    {
        $configKeys = array_keys($configArr);
        $itemList = ForumConfig::find($configKeys);
        $dataMap = [];
        foreach ($itemList as $item) {
            $dataMap[$item->item_key] = $item;
        }
        foreach ($configArr as $itemKey => $itemValue) {
            if (isset($dataMap[$itemKey])) {
                $obj = $dataMap[$itemKey];
                $obj->item_value = $itemValue;
            } else {
                $obj = new ForumConfig(['item_key' => $itemKey, 'item_value' => $itemValue]);
            }
            $obj->save();
            $this->config->put($itemKey, $itemValue);
            Cache::put($this->getItemCacheKey($itemKey), $itemValue, $this->cacheExpiredTime);
        }
    }

    /**
     * 清理配置缓存
     * @param array $itemKeyArr
     * @return void
     */
    public function clearCache(array $itemKeyArr)
    {
        $this->config->forget($itemKeyArr);
        foreach ($itemKeyArr as $itemKey) {
            Cache::forget($this->getItemCacheKey($itemKey));
        }
    }
}
