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

class ForumController extends Controller
{
    /**
     * @param int $id
     * @param int $page
     * @return array
     */
    public function show($id, $page)
    {
        /**
         * @var Forum $forum
         */
        $forum = Forum::with(['avatarFile', 'forumGroup', 'childForums', 'topics'])->findOrFail($id);
        return view('forum.show', ['forum' => $forum]);
    }

    public function group($id)
    {

        $groupInfo = ForumGroup::with('childForums')->findOrFail($id);
        return view('forum.group', ['groupInfo' => $groupInfo]);
    }
}
