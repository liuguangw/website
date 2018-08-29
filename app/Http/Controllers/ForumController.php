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

class ForumController extends Controller
{

    /**
     * @param PaginatorService $paginatorService
     * @param int $id
     * @param string|int $type 帖子类别
     * @param string $filter 分类(所有|精华|顶置)
     * @param string $order 排序
     * @param int $page
     * @return array
     */
    public function show(PaginatorService $paginatorService, $id, $type, $filter, $order, $page = 1)
    {
        /**
         * @var Forum $forum
         */
        $forum = Forum::with(['avatarFile', 'forumGroup', 'childForums'])->findOrFail($id);
        $builder = $forum->topics()->with(['author', 'topicType']);
        if ($type != 'all') {
            $type = intval($type);
            $builder->where(['topic_type_id' => $type]);
        }
        if ($filter == 'good') {
            $builder->where(['t_good' => 1]);
        } elseif ($filter == 'top') {
            $builder->where('order_id', '>', 1);
        }
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
        $topics = $builder
            ->paginate(10, ['*'], 'page', $page);
        if (($page < 1) || ($page > $topics->lastPage())) {
            abort(404);
        }
        $routeParams = ['id' => $id, 'type' => $type, 'filter' => $filter, 'order' => $order];
        $pagination = $paginatorService->links($topics, function (int $page, array $params = []) {
            $params['page'] = $page;
            return route('forum', $params);
        }, $routeParams);
        $routeParams['page'] = 1;
        return view('forum.show', ['forum' => $forum, 'topics' => $topics, 'pagination' => $pagination, 'routeParams' => $routeParams]);
    }

    public function group($id)
    {

        $groupInfo = ForumGroup::with('childForums')->findOrFail($id);
        return view('forum.group', ['groupInfo' => $groupInfo]);
    }
}
