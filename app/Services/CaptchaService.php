<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/20
 * Time: 10:08
 */

namespace App\Services;

use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class CaptchaService
{
    private $sessionKey = 'captcha_code';

    /**
     * 验证码响应
     *
     * @return StreamedResponse
     */
    public function getCaptchaResponse()
    {
        $key = $this->sessionKey;
        $response = new StreamedResponse(function () use ($key) {
            $phraseBuilder = new PhraseBuilder(4);
            $captcha = new CaptchaBuilder(null, $phraseBuilder);
            $captcha->build();
            //将验证码字符串存入session
            session([$key => $captcha->getPhrase()]);
            //输出
            $captcha->output();
        }, 200, ['Content-Type' => 'image/jpeg']);
        return $response;
    }

    /**
     * 检测验证码是否正确
     *
     * @param Request $request 用户请求
     * @param string $input 用户输入的验证码
     * @return bool
     */
    public function checkCaptchaCode(Request $request, string $input)
    {
        $code = $request->session()->pull($this->sessionKey, '');
        if ($code == '') {
            return false;
        } else {
            return strcasecmp($code, $input) == 0;
        }
    }
}
