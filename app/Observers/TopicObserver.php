<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/24
 * Time: 11:49
 */

namespace App\Observers;


use App\Models\Topic;

class TopicObserver
{
    public function creating(Topic $topic)
    {
        $createdTime = now();
        $topic->post_time = $createdTime;
        $topic->last_active_time = $createdTime;
        //用户:post+1
        $topic->author->increment('post_count');
        //类别:post+1
        $topicType = $topic->topicType;
        if (!empty($topicType)) {
            $topicType->increment('post_count');
        }
    }

    public function updating(Topic $topic)
    {
        if ($topic->isDirty('title')) {
            $topic->last_modify_time = now();
        }
        if ($topic->isDirty('reply_count')) {
            $topic->reply_time = now();
            $topic->last_active_time = now();
        }
    }

    public function created(Topic $topic)
    {
        //论坛数据更新
        $topic->forum->onNewPost($topic);
    }
}
