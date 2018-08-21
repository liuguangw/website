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
    }
}
