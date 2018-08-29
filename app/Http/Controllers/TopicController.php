<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 10:20
 */

namespace App\Http\Controllers;


use App\Models\Forum;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Http\Requests\TopicCreate;

class TopicController extends Controller
{

    public function needLogin()
    {
        return true;
    }

    protected function useAuthMiddleware()
    {
        //这些操作需要登录
        parent::useAuthMiddleware()->only(['create', 'store']);
    }

    /**
     * 发表帖子页面
     * @param $id 论坛id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $forum = Forum::with(['topicTypes'])->findOrFail($id);
        return view('topic.create_and_edit', [
            'forum' => $forum,
            'actionUrl' => action('TopicController@store')
        ]);
    }

    public function store(TopicCreate $request)
    {
        $formRequest = $request->request;
        $topic = new Topic();
        $topic->title = $formRequest->get('title', '');
        $topic->forum_id = intval($formRequest->get('forum_id', 0));
        $topic->user_id = $request->user()->id;
        $topic->topic_type_id = intval($formRequest->get('topic_type', 0));
        $topic->save();
        $topicContent = new TopicContent();
        $topicContent->content = $formRequest->get('content', '');
        $topic->topicContent()->save($topicContent);
        return $topic->toArray();
    }

    public function show(int $id, int $page)
    {
        $topic = Topic::with(['forum', 'author', 'TopicType', 'topicContent', 'replies'])->findOrFail($id);
        return view('topic.show', [
            'topic' => $topic,
            'forum' => $topic->forum,
            'topicAuthor' => $topic->author,
            'content' => $topic->topicContent->content,
            'replies' => $topic->replies
        ]);
    }
}
