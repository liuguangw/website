<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeNow = now();
        $forumGroup = new \App\Models\ForumGroup();
        $forumGroup->name = '默认分区';
        $forumGroup->save();
        $forums = [];
        for ($i = 1; $i <= 6; $i++) {
            $forum = new \App\Models\Forum();
            $forum->name = '板块' . $i;
            $forum->is_root = ($i <= 3);
            $forum->is_deleted = ($i == 2);
            $forum->color = ($i == 5) ? 'green' : '';
            $forum->forumGroup()->associate($forumGroup);
            $forum->save();
            $forums[] = $forum;
        }
        DB::table('forum_trees')->insert([
            ['parent_forum_id' => 1, 'forum_id' => 1, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 2, 'forum_id' => 2, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 3, 'forum_id' => 3, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 3, 'forum_id' => 4, 'tree_deep' => 1, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 3, 'forum_id' => 5, 'tree_deep' => 1, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 3, 'forum_id' => 6, 'tree_deep' => 2, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 4, 'forum_id' => 4, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 5, 'forum_id' => 5, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 5, 'forum_id' => 6, 'tree_deep' => 1, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['parent_forum_id' => 6, 'forum_id' => 6, 'tree_deep' => 0, 'created_at' => $timeNow, 'updated_at' => $timeNow]
        ]);
        /**
         * @var \App\Models\Forum $opForum
         */
        $opForum = $forums[4];
        $topicTypes = [];
        $colors = ['', 'green', 'red'];
        //插入默认类别
        for ($i = 0; $i < 3; $i++) {
            $topicType = new \App\Models\TopicType();
            $topicType->name = '类别' . ($i + 1);
            $topicType->color = $colors[$i];
            $topicType->forum()->associate($opForum);
            $topicType->save();
            $topicTypes[] = $topicType;
        }
        //插入默认帖子
        $opUser = \App\Models\User::find(1);
        for ($i = 0; $i < 200; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $topic = new \App\Models\Topic();
                $topic->forum()->associate($opForum);
                $topic->author()->associate($opUser);
                if (isset($topicTypes[$j])) {
                    $topic->topicType()->associate($topicTypes[$j]);
                } else {
                    $topic->topic_type_id = 0;
                }
                $topic->title = '帖子' . ($i * 5 + $j + 1);
                if (in_array($j, [2, 4])) {
                    $topic->color = 'red';
                } elseif ($j == 3) {
                    $topic->color = '#000';
                }
                $topic->save();
                $topicContent = new \App\Models\TopicContent();
                $topicContent->content = $topic->title . '的内容。。。';
                $topic->topicContent()->save($topicContent);
            }
        }
    }
}
