<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 10:50
 */

namespace App\Observers;


use App\Models\TopicContent;

class TopicContentObserver
{
    /**
     * 处理内容修改事件
     * @param TopicContent $topicContent
     * @return void|bool
     */
    public function updating(TopicContent $topicContent)
    {
        $topic = $topicContent->topic;
        if ($topic->t_disabled) {
            //帖子屏蔽后不允许修改
            return false;
        }
        //更新帖子修改时间
        $topic->last_modify_time = now();
        $topic->save();
    }
}
