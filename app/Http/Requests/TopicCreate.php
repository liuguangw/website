<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/28
 * Time: 14:34
 */

namespace App\Http\Requests;


use App\Models\TopicType;
use Illuminate\Foundation\Http\FormRequest;

class TopicCreate extends FormRequest
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
            'forum_id' => 'required|numeric|exists:forums,id',
            'topic_type' => 'required|numeric',
            'title' => 'required|string|between:3,30',
            'content' => 'required|string|between:3,20000'
        ];
    }

    public function attributes()
    {
        return [
            'forum_id' => '论坛id',
            'topic_type' => '帖子类别',
            'title' => '标题',
            'content' => '内容'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute不能为空',
            'numeric' => ':attribute必须是数字',
            'between' => ':attribute只能包含:min - :max个字符',
            'min' => ':attribute至少需要:min个字符',
            'max' => ':attribute最多只能输入:max个字符',
            'exists' => ':attribute无效'
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
            $topicTypeId = intval($request->request->get('topic_type', 0));
            $forumId = intval($request->request->get('forum_id', 0));
            if ($topicTypeId != 0) {
                $topicTypeInfo = TopicType::where(['id' => $topicTypeId, 'forum_id' => $forumId])->first();
                if (empty($topicTypeInfo)) {
                    $validator->errors()->add('topic_type', '帖子类别无效');
                }
            }
        });
    }

}
