<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\CaptchaService;

class UserLogin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|alpha_num|between:4,14|exists:users',
            'password' => 'required|string|between:5,30',
            'captcha_code' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'captcha_code' => '验证码'
        ];
    }

    public function messages()
    {
        return [
            'required' => '请输入:attribute',
            'alpha_num' => ':attribute格式错误',
            'between' => ':attribute格式错误',
            'exists'=>'此用户不存在'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $request = $this;
        $validator->after(function ($validator) use ($request) {
            /**
             * @var CaptchaService
             */
            $captchaService = app(CaptchaService::class);
            $inputCode = $request->request->get('captcha_code', null);
            if (!isset($inputCode)) {
                $inputCode = '';
            }
            if (!$captchaService->checkCaptchaCode($request, $inputCode)) {
                $validator->errors()->add('captcha_code', '验证码错误');
            }
        });
    }
}
