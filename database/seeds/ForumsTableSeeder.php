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
                'deleted_at' => ($i == 2) ? $timeNow : null
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
        DB::table('forum_types')->insert([
            ['forum_id' => 5, 'name' => '类别1', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['forum_id' => 5, 'name' => '类别2', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['forum_id' => 5, 'name' => '类别3', 'created_at' => $timeNow, 'updated_at' => $timeNow]
        ]);
        //插入默认帖子
        DB::table('topics')->insert([
            ['forum_id' => 5, 'user_id' => 1, 'forum_type_id' => 0, 'title' => '帖子1', 'color' => '', 'post_time' => $timeNow, 'last_active_time' => $timeNow],
            ['forum_id' => 5, 'user_id' => 1, 'forum_type_id' => 1, 'title' => '帖子2', 'color' => '', 'post_time' => $timeNow, 'last_active_time' => $timeNow],
            ['forum_id' => 5, 'user_id' => 1, 'forum_type_id' => 1, 'title' => '帖子3', 'color' => 'red', 'post_time' => $timeNow, 'last_active_time' => $timeNow],
            ['forum_id' => 5, 'user_id' => 1, 'forum_type_id' => 1, 'title' => '帖子4', 'color' => '#000', 'post_time' => $timeNow, 'last_active_time' => $timeNow],
            ['forum_id' => 5, 'user_id' => 1, 'forum_type_id' => 0, 'title' => '帖子5', 'color' => 'red', 'post_time' => $timeNow, 'last_active_time' => $timeNow]
        ]);
        DB::table('topic_contents')->insert([
            ['topic_id' => 1, 'content' => '内容1', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['topic_id' => 2, 'content' => '内容2', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['topic_id' => 3, 'content' => '内容3', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['topic_id' => 4, 'content' => '内容4', 'created_at' => $timeNow, 'updated_at' => $timeNow],
            ['topic_id' => 5, 'content' => '内容5', 'created_at' => $timeNow, 'updated_at' => $timeNow]
        ]);
    }
}
