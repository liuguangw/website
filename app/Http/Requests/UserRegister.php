<?php

namespace App\Http\Requests;

use App\Services\CaptchaService;
use Illuminate\Foundation\Http\FormRequest;

class UserRegister extends FormRequest
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
            'username' => 'required|alpha_num|between:4,14|unique:users',
            'nickname' => 'required|string|max:16',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|string|between:5,30|confirmed',
            'captcha_code' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'nickname' => '昵称',
            'email' => '邮箱',
            'password' => '密码',
            'captcha_code' => '验证码'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute不能为空',
            'alpha_num' => ':attribute只能包含字母和数字',
            'between' => ':attribute只能包含:min - :max个字符',
            'min' => ':attribute至少需要:min个字符',
            'max' => ':attribute最多只能输入:max个字符',
            'unique' => '此:attribute已经被使用了',
            'email' => ':attribute格式不正确',
            'confirmed' => '两次输入的:attribute不一致'
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
