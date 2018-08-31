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
use Illuminate\Support\Facades\Auth;

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
        $reply = new Reply();
        $data = $request->validated();
        $reply->fill($data);
        $reply->topic_id = intval($data['topic_id']);
        $reply->user_id = Auth::user()->id;
        $reply->save();
        return back()->with('reply_success', true);
    }
}
