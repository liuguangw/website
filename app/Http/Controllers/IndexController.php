<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/16
 * Time: 12:20
 */

namespace App\Http\Controllers;


use App\Models\Forum;
use App\Models\ForumGroup;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Services\CaptchaService;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $forumGroups = ForumGroup::with('childForums')->get();
        return view('index.index', ['forumGroups' => $forumGroups]);
    }

    /**
     * 图形验证码
     *
     * @param CaptchaService $captchaService
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function captcha(CaptchaService $captchaService)
    {
        return $captchaService->getCaptchaResponse();
    }

    public function debug(Request $request)
    {
        $destId = rand(1, 1000);
        $destId = 380;
        $topic = Topic::find($destId);
        $user = User::find(1);
        $reply = new Reply();
        $reply->author()->associate($user);
        $reply->topic()->associate($topic);
        $reply->content = 'hello at ' . now()->toDateTimeString();
        $reply->save();
        dump($topic->toArray(),$request->session()->all());
        return '';
    }
}
