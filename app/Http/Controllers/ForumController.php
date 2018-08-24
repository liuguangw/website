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
     * @param PaginatorService $paginatorService
     * @param int $id
     * @param int $page
     * @return array
     */
    public function show(PaginatorService $paginatorService, $id, $page = 1)
    {
        /**
         * @var Forum $forum
         */
        $forum = Forum::with(['avatarFile', 'forumGroup', 'childForums'])->findOrFail($id);
        $topics = $forum->topics()->with('author')
            ->orderByDesc('order_id')
            ->orderByDesc('last_active_time')
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'page', $page);
        if (($page < 1) || ($page > $topics->lastPage())) {
            abort(404);
        }
        $pagination = $paginatorService->links($topics, function (int $page, array $params = []) {
            $params['page'] = $page;
            return route('forum', $params);
        }, ['id' => $id]);
        return view('forum.show', ['forum' => $forum, 'topics' => $topics, 'pagination' => $pagination]);
    }

    public function group($id)
    {

        $groupInfo = ForumGroup::with('childForums')->findOrFail($id);
        return view('forum.group', ['groupInfo' => $groupInfo]);
    }
}
