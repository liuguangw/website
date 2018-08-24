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
use App\Models\Topic;
use App\Services\CaptchaService;
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
        $topic = Topic::find(1);
        $topic->title = 'test-' . now();
        $topic->view_count += 1;
        $topic->reply_count += 1;
        $topic->save();
        return $topic->toArray();
    }
}
