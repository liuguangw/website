<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 15:46
 */

namespace App\Observers;


use App\Models\Reply;

//use Illuminate\Support\Facades\Log;

class ReplyObserver
{

    public function creating(Reply $reply)
    {
        /*帖子被锁定后禁止回复*/
        if ($reply->topic->t_locked) {
            return false;
        }
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
        //更新回复时间、最后回复人信息
        $topic->reply_time = now();
        $topic->last_active_time = $topic->reply_time;
        $topic->reply_user_id = $reply->user_id;
        $topic->save();
        //帖子:reply+1
        $topic->increment('reply_count');
        //用户:reply+1
        $reply->author->increment('reply_count');
        //Log::debug('under creating');
    }

    public function created(Reply $reply)
    {
        //论坛数据更新
        $reply->topic->forum->onNewReply($reply);
    }
}
