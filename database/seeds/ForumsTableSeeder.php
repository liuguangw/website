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
        $forumGroupId = DB::table('forum_groups')->insertGetId([
            'name' => '默认分区',
            'created_at' => $timeNow,
            'updated_at' => $timeNow
        ]);
        $forums = [];
        for ($i = 1; $i <= 6; $i++) {
            $forums[] = [
                'forum_group_id' => $forumGroupId,
                'name' => '板块' . $i,
                'description' => '',
                'created_at' => $timeNow,
                'updated_at' => $timeNow,
                'is_root' => ($i <= 3) ? 1 : 0,
                'deleted_at' => ($i == 2) ? $timeNow : null,
                'color' => ($i == 5) ? 'green' : ''
            ];
        }
        DB::table('forums')->insert($forums);
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
        //插入默认类别
        DB::table('topic_types')->insert([
            ['forum_id' => 5, 'name' => '类别1', 'color' => '', 'post_count' => 200, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['forum_id' => 5, 'name' => '类别2', 'color' => 'green','post_count' => 400, 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['forum_id' => 5, 'name' => '类别3', 'color' => 'red','post_count' => 200, 'created_at' => $timeNow, 'updated_at' => $timeNow]
        ]);
        //插入默认帖子
        $topicsArr = [];
        for ($i = 0; $i < 200; $i++) {
            $topicsArr[] = ['forum_id' => 5, 'user_id' => 1, 'topic_type_id' => 0, 'title' => '帖子' . ($i * 5 + 1), 'color' => '', 'post_time' => $timeNow, 'last_active_time' => $timeNow];
            $topicsArr[] = ['forum_id' => 5, 'user_id' => 1, 'topic_type_id' => 1, 'title' => '帖子' . ($i * 5 + 2), 'color' => '', 'post_time' => $timeNow, 'last_active_time' => $timeNow];
            $topicsArr[] = ['forum_id' => 5, 'user_id' => 1, 'topic_type_id' => 2, 'title' => '帖子' . ($i * 5 + 3), 'color' => 'red', 'post_time' => $timeNow, 'last_active_time' => $timeNow];
            $topicsArr[] = ['forum_id' => 5, 'user_id' => 1, 'topic_type_id' => 2, 'title' => '帖子' . ($i * 5 + 4), 'color' => '#000', 'post_time' => $timeNow, 'last_active_time' => $timeNow];
            $topicsArr[] = ['forum_id' => 5, 'user_id' => 1, 'topic_type_id' => 3, 'title' => '帖子' . ($i * 5 + 5), 'color' => 'red', 'post_time' => $timeNow, 'last_active_time' => $timeNow];
        }
        DB::table('topics')->insert($topicsArr);
        $topicsArr = null;
        $contentsArr = [];
        for ($i = 1; $i <= 1000; $i++) {
            $topicsArr[] = ['topic_id' => $i, 'content' => '内容------' . $i, 'created_at' => $timeNow, 'updated_at' => $timeNow];
        }
        DB::table('topic_contents')->insert($contentsArr);
    }
}
