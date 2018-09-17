<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumMetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forum_metas')->insert([
            // 默认金币、经验规则
            ['forum_id' => 5, 'meta_item_key' => 'post_topic.coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'post_topic.exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'post_reply.coin', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'post_reply.exp', 'meta_item_value' => '1'],

            ['forum_id' => 5, 'meta_item_key' => 'top_topic.coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'top_topic.exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'untop_topic.clear_coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'untop_topic.clear_exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'good_topic.coin', 'meta_item_value' => '3'],
            ['forum_id' => 5, 'meta_item_key' => 'good_topic.exp', 'meta_item_value' => '3'],

            ['forum_id' => 5, 'meta_item_key' => 'ungood_topic.clear_coin', 'meta_item_value' => '3'],
            ['forum_id' => 5, 'meta_item_key' => 'ungood_topic.clear_exp', 'meta_item_value' => '3'],

            ['forum_id' => 5, 'meta_item_key' => 'lock_topic.clear_coin', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'lock_topic.clear_exp', 'meta_item_value' => '1'],

            ['forum_id' => 5, 'meta_item_key' => 'unlock_topic.coin', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'unlock_topic.exp', 'meta_item_value' => '1'],

            ['forum_id' => 5, 'meta_item_key' => 'block_topic.clear_coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'block_topic.clear_exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'unblock_topic.coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'unblock_topic.exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'delete_topic.clear_coin', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'delete_topic.clear_exp', 'meta_item_value' => '1'],

            ['forum_id' => 5, 'meta_item_key' => 'undelete_topic.coin', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'undelete_topic.exp', 'meta_item_value' => '1'],

            ['forum_id' => 5, 'meta_item_key' => 'block_reply.clear_coin', 'meta_item_value' => '3'],
            ['forum_id' => 5, 'meta_item_key' => 'block_reply.clear_exp', 'meta_item_value' => '3'],

            ['forum_id' => 5, 'meta_item_key' => 'unblock_reply.coin', 'meta_item_value' => '3'],
            ['forum_id' => 5, 'meta_item_key' => 'unblock_reply.exp', 'meta_item_value' => '3'],

            ['forum_id' => 5, 'meta_item_key' => 'delete_reply.clear_coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'delete_reply.clear_exp', 'meta_item_value' => '2'],

            ['forum_id' => 5, 'meta_item_key' => 'undelete_reply.coin', 'meta_item_value' => '2'],
            ['forum_id' => 5, 'meta_item_key' => 'undelete_reply.exp', 'meta_item_value' => '2'],
            //等级限制
            ['forum_id' => 5, 'meta_item_key' => 'min_level.post_topic', 'meta_item_value' => '0'],
            ['forum_id' => 5, 'meta_item_key' => 'min_level.post_reply', 'meta_item_value' => '0'],
            ['forum_id' => 5, 'meta_item_key' => 'min_level.view_forum', 'meta_item_value' => '0'],
            ['forum_id' => 5, 'meta_item_key' => 'min_level.view_topic', 'meta_item_value' => '0'],
            ['forum_id' => 5, 'meta_item_key' => 'min_level.view_reply', 'meta_item_value' => '0'],
            //游客限制
            ['forum_id' => 5, 'meta_item_key' => 'guest.can_view_forum', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'guest.can_view_topic', 'meta_item_value' => '1'],
            ['forum_id' => 5, 'meta_item_key' => 'guest.can_view_reply', 'meta_item_value' => '0'],
            // 黑名单发言限制
            ['forum_id' => 5, 'meta_item_key' => 'block_user.can_post_topic', 'meta_item_value' => '0'],
            ['forum_id' => 5, 'meta_item_key' => 'block_user.can_post_reply', 'meta_item_value' => '0']
        ]);
    }
}
