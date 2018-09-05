<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/22
 * Time: 11:55
 */

namespace App\Http\Controllers;


use App\Models\Forum;
use App\Models\ForumGroup;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    /**
     * 论坛帖子列表页
     * @param PaginatorService $paginatorService
     * @param Request $request
     * @param $id 论坛id
     * @param int $page 页码id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PaginatorService $paginatorService, Request $request, $id, $page = 1)
    {
        //输入参数获取
        $query = $request->query;
        $type = $query->get('type', 'all');
        $filter = $query->get('filter', 'all');
        $order = $query->get('order', 'common');
        /**
         * @var Forum $forum
         */
        $forum = Forum::with(['avatarFile', 'forumGroup', 'childForums'])->findOrFail($id);
        $builder = $forum->topics()->with(['author', 'topicType', 'lastReplyUser']);
        //类别筛选
        if ($type != 'all') {
            $type = intval($type);
            $builder->where(['topic_type_id' => $type]);
        }
        //其它筛选
        if ($filter == 'good') {
            $builder->where(['t_good' => 1]);
        } elseif ($filter == 'top') {
            $builder->where('order_id', '>', 1);
        }
        //排序
        if ($order == 'common') {
            $builder
                ->orderByDesc('order_id')
                ->orderByDesc('last_active_time')
                ->orderByDesc('id');
        } elseif ($order == 'latest') {
            $builder
                ->orderByDesc('id');

        } elseif ($order == 'hot') {
            $builder
                ->orderByDesc('reply_count')
                ->orderByDesc('view_count')
                ->orderByDesc('id');

        }
        //分页
        $topics = $builder
            ->paginate(10, ['*'], 'page', $page);
        if (($page < 1) || ($page > $topics->lastPage())) {
            abort(404);
        }
        //用于URL生成的路由参数
        $routeParams = $query->all();
        $routeParams['id'] = $id;
        $routeParams['page'] = '';
        //分页栏数据
        $pagination = $paginatorService->links($topics, function (int $page, array $params = []) {
            if ($page != 1) {
                $params['page'] = $page;
            }
            return route('forum', $params);
        }, $routeParams);
        return view('forum.show', [
            'forum' => $forum,
            'topics' => $topics,
            'pagination' => $pagination,
            'routeParams' => $routeParams,
            'extraParams' => ['type' => $type, 'filter' => $filter, 'order' => $order]
        ]);
    }

    public function group($id)
    {

        $groupInfo = ForumGroup::with('childForums')->findOrFail($id);
        return view('forum.group', ['groupInfo' => $groupInfo]);
    }
}
