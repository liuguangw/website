<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 15:46
 */

namespace App\Observers;


use App\Models\Reply;

class ReplyObserver
{

    public function creating(Reply $reply)
    {
        /**
         * @var Reply $lastReply
         */
        $lastReply = Reply::where(['topic_id' => $reply->topic_id])->orderByDesc('id')->first();
        //处理楼层
        if (empty($lastReply)) {
            $reply->floor_id = 1;
        } else {
            $reply->floor_id = $lastReply->floor_id + 1;
        }
        //处理回复数
        $topic = $reply->topic;
        //更新回复时间
        $topic->reply_time = now();
        $topic->last_active_time = $topic->reply_time;
        $topic->save();
        //帖子:reply+1
        $topic->increment('reply_count');
        //论坛:reply+1
        $topic->forum->onNewReply();
        //用户:reply+1
        $reply->author->increment('post_count');

    }
}
