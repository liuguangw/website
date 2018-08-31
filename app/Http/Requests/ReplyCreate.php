<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/31
 * Time: 12:09
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use App\Services\CaptchaService;

class ReplyCreate extends FormRequest
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
            'topic_id' => 'required|numeric|exists:topics,id',
            'to_floor_id' => 'required|numeric',
            'content' => 'required|string|min:5|max:800',
            'captcha_code' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'topic_id' => '帖子id',
            'to_floor_id' => '楼层id',
            'content' => '回复内容',
            'captcha_code' => '验证码'
        ];
    }

    public function messages()
    {
        return [
            'required' => '请输入:attribute',
            'numeric' => ':attribute必须是数字',
            'min' => ':attribute至少需要输入:min个字符',
            'max' => ':attribute最多只能输入:max个字符',
            'alpha_num' => ':attribute格式错误',
            'exists' => ':attribute不存在'
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
            if ($inputCode != '') {
                if (!$captchaService->checkCaptchaCode($request, $inputCode)) {
                    $validator->errors()->add('captcha_code', '验证码错误');
                }
            }
        });
    }
}
