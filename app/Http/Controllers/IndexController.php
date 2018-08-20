<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/16
 * Time: 12:20
 */

namespace App\Http\Controllers;


use App\Services\CaptchaService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return 'hello world';
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

    public function debug(Request $request){
        dump($request->session()->all(),$request->cookies->all());
        return '';
    }
}
