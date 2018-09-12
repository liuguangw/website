<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/31
 * Time: 12:07
 */

namespace App\Http\Controllers;


use App\Http\Requests\ReplyCreate;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Log;

/**
 * 回复
 * @package App\Http\Controllers
 */
class ReplyController extends Controller
{
    public function needLogin()
    {
        return true;
    }

    protected function useAuthMiddleware()
    {
        //这些操作需要登录
        parent::useAuthMiddleware()->only(['store']);
    }

    public function store(ReplyCreate $request)
    {
        $data = $request->validated();
        $topicId = intval($data['topic_id']);
        $topic = Topic::find($topicId);
        if (empty($topic)) {
            return back()->withErrors('帖子不存在');
        } elseif ($topic->t_locked) {
            return back()->withErrors('帖子已被锁定不能回复');
        }
        $reply = new Reply();
        $reply->fill($data);
        $reply->topic()->associate($topic);
        $reply->author()->associate(Auth::user());
        DB::transaction(function () use ($reply) {
            //Log::debug('before save');
            $reply->save();
            //Log::debug('after save');
        });
        //Log::debug('out transaction');
        return back()->with('success', '回复成功');
    }
}
