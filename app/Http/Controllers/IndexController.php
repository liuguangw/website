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
        $forumGroups = ForumGroup::with('childForums')->get();
        dump($forumGroups->toArray());
        /**
         * @var Forum $forum
         */
        $forum = Forum::with(['childForums', 'allChildForums', 'avatarFile'])->find(3);
        dump($forum->toArray());
        /**
         * @var Forum $forum
         */
        $forum = Forum::with('parentForums')->find(6);
        dump($forum->toArray());
        return '';
    }
}
