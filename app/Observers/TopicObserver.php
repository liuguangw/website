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
    }

    public function updating(Topic $topic)
    {
        if ($topic->isDirty('title')) {
            $topic->last_modify_time = now();
        }
        if ($topic->isDirty('reply_count')) {
            //被锁定时,禁止回复
            if($topic->t_locked){
                return false;
            }
            $topic->reply_time = now();
            $topic->last_active_time = now();
        }
    }
}
