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
use App\Models\TopicType;
use App\Services\PaginatorService;
use App\Services\TopicService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    /**
     * 保存帖子数据
     * @param TopicCreate $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicCreate $request)
    {
        $forumId = intval($request->input('forum_id', 0));
        $forum = Forum::find($forumId);
        if (empty($forum)) {
            return back()->withErrors('不存在此论坛');
        }
        $topic = new Topic();
        $topic->fill($request->only('title'));
        //关联论坛和用户
        $topic->forum()->associate($forum);
        $topic->author()->associate(Auth::user());
        //帖子类别
        $topicTypeId = intval($request->input('topic_type', 0));
        if ($topicTypeId == 0) {
            $topic->topic_type_id = $topicTypeId;
        } else {
            $typeInfo = TopicType::where(['id' => $topicTypeId, 'forum_id' => $forum->id])->first();
            if (empty($typeInfo)) {
                return back()->withErrors('无效的帖子类别');
            } else {
                $topic->topicType()->associate($typeInfo);
            }
        }
        DB::beginTransaction();
        try {
            $topic->save();
            $topicContent = new TopicContent();
            $topicContent->fill($request->only('content'));
            $topic->topicContent()->save($topicContent);
            DB::commit();
            return redirect()->to($forum->link());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * 帖子详情页
     * @param PaginatorService $paginatorService
     * @param TopicService $topicService
     * @param int $id
     * @param int $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PaginatorService $paginatorService, TopicService $topicService, int $id, int $page = 1)
    {
        $topic = Topic::with(['forum', 'author', 'TopicType', 'topicContent', 'replies'])->findOrFail($id);
        $topicService->processViewCount($topic);
        $builder = $topic->replies()->with('author')->orderBy('id');
        $replies = $builder->paginate(15, ['*'], 'page', $page);
        if (($page < 1) || ($page > $replies->lastPage())) {
            abort(404);
        }
        $routeParams = ['id' => $id];
        $pagination = $paginatorService->links($replies, function (int $page, array $params = []) {
            $params['page'] = $page;
            return action('TopicController@show', $params);
        }, $routeParams);
        if (Auth::check()) {
            $topic->load('likeLog');
            $replies->load('likeLog');
        }
        return view('topic.show', [
            'topic' => $topic,
            'topicType' => $topic->topicType,
            'forum' => $topic->forum,
            'topicAuthor' => $topic->author,
            'replies' => $replies,
            'pagination' => $pagination,
            'page' => $page
        ]);
    }
}
