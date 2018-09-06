<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/6
 * Time: 16:20
 */

namespace App\Services;


use App\Models\Topic;
use Illuminate\Support\Facades\Cache;

class TopicService
{
    /**
     * 处理查看帖子时,帖子的阅读数
     * @param Topic $topic
     * @return void
     */
    public function processViewCount(Topic $topic)
    {
        $key = 'topic.' . $topic->id . '.ip_' . request()->ip() . '.read_count';
        if (!Cache::has($key)) {
            Cache::put($key, 1, now()->addDays(3));
            //增加阅读数
            $topic->increment('view_count');
        }
    }
}
