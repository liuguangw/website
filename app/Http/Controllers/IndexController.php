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
        $time1=new Carbon('2018-08-28 15:56:00');
        $time2=new Carbon('2018-08-28 16:57:00');
        dump($time1,$time2,$time2->diffInMinutes($time1));
        return '';
    }
}
