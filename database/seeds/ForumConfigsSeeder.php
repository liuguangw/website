<?php

use Illuminate\Database\Seeder;
use App\Services\ForumConfigService;
use Illuminate\Support\Facades\DB;

class ForumConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forum_configs')->insert([
            // 默认金币、经验规则
            ['item_key' => 'post_topic.coin', 'description' => '发表主题帖奖励金币', 'item_value' => 3],
            ['item_key' => 'post_topic.exp', 'description' => '发表主题帖奖励经验', 'item_value' => 3],

            ['item_key' => 'post_reply.coin', 'description' => '发表回帖奖励金币', 'item_value' => 0],
            ['item_key' => 'post_reply.exp', 'description' => '发表回帖奖励经验', 'item_value' => 1],

            ['item_key' => 'top_topic.coin', 'description' => '顶置帖子奖励金币', 'item_value' => 5],
            ['item_key' => 'top_topic.exp', 'description' => '顶置帖子奖励经验', 'item_value' => 5],

            ['item_key' => 'untop_topic.clear_coin', 'description' => '取消顶置帖子时回收金币', 'item_value' => 5],
            ['item_key' => 'untop_topic.clear_exp', 'description' => '取消顶置帖子时回收经验', 'item_value' => 5],

            ['item_key' => 'good_topic.coin', 'description' => '精华帖子奖励金币', 'item_value' => 8],
            ['item_key' => 'good_topic.exp', 'description' => '精华帖子奖励经验', 'item_value' => 8],

            ['item_key' => 'ungood_topic.clear_coin', 'description' => '取消精华帖子时回收金币', 'item_value' => 8],
            ['item_key' => 'ungood_topic.clear_exp', 'description' => '取消精华帖子时回收经验', 'item_value' => 8],

            ['item_key' => 'lock_topic.clear_coin', 'description' => '锁定帖子清除金币', 'item_value' => 0],
            ['item_key' => 'lock_topic.clear_exp', 'description' => '锁定帖子清除经验', 'item_value' => 1],

            ['item_key' => 'unlock_topic.coin', 'description' => '解锁帖子时返还金币', 'item_value' => 0],
            ['item_key' => 'unlock_topic.exp', 'description' => '解锁帖子时返还经验', 'item_value' => 1],

            ['item_key' => 'block_topic.clear_coin', 'description' => '屏蔽帖子清除金币', 'item_value' => 0],
            ['item_key' => 'block_topic.clear_exp', 'description' => '屏蔽帖子清除经验', 'item_value' => 5],

            ['item_key' => 'unblock_topic.coin', 'description' => '取消屏蔽帖子时返还金币', 'item_value' => 0],
            ['item_key' => 'unblock_topic.exp', 'description' => '取消屏蔽帖子时返还经验', 'item_value' => 5],

            ['item_key' => 'delete_topic.clear_coin', 'description' => '删除帖子清除金币', 'item_value' => 0],
            ['item_key' => 'delete_topic.clear_exp', 'description' => '删除帖子清除经验', 'item_value' => 5],

            ['item_key' => 'undelete_topic.coin', 'description' => '恢复删除的帖子时返还金币', 'item_value' => 0],
            ['item_key' => 'undelete_topic.exp', 'description' => '恢复删除的帖子时返还经验', 'item_value' => 5],

            ['item_key' => 'block_reply.clear_coin', 'description' => '屏蔽回帖清除金币', 'item_value' => 0],
            ['item_key' => 'block_reply.clear_exp', 'description' => '屏蔽回帖清除经验', 'item_value' => 3],

            ['item_key' => 'unblock_reply.coin', 'description' => '取消屏蔽回帖时返还金币', 'item_value' => 0],
            ['item_key' => 'unblock_reply.exp', 'description' => '取消屏蔽回帖时返还经验', 'item_value' => 3],

            ['item_key' => 'delete_reply.clear_coin', 'description' => '删除回帖清除金币', 'item_value' => 0],
            ['item_key' => 'delete_reply.clear_exp', 'description' => '删除回帖清除经验', 'item_value' => 3],

            ['item_key' => 'undelete_reply.coin', 'description' => '恢复删除的回帖时返还金币', 'item_value' => 0],
            ['item_key' => 'undelete_reply.exp', 'description' => '恢复删除的回帖时返还经验', 'item_value' => 3],
            //等级限制
            ['item_key' => 'min_level.post_topic', 'description' => '发表帖子的最低等级', 'item_value' => 1],
            ['item_key' => 'min_level.post_reply', 'description' => '发表回帖的最低等级', 'item_value' => 0],
            ['item_key' => 'min_level.view_forum', 'description' => '查看论坛的最低等级', 'item_value' => 0],
            ['item_key' => 'min_level.view_topic', 'description' => '查看帖子的最低等级', 'item_value' => 0],
            ['item_key' => 'min_level.view_reply', 'description' => '查看回帖的最低等级', 'item_value' => 0],
            //游客限制
            ['item_key' => 'guest.can_view_forum', 'description' => '游客是否能查看论坛', 'item_value' => 1],
            ['item_key' => 'guest.can_view_topic', 'description' => '游客是否能查看帖子', 'item_value' => 1],
            ['item_key' => 'guest.can_view_reply', 'description' => '游客是否能查看回帖', 'item_value' => 1],
            //基本配置
            ['item_key' => 'site.name', 'description' => '网站名称', 'item_value' => '流光网']
        ]);
    }
}
