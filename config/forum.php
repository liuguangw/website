<?php
/**
 * 论坛配置
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/14
 * Time: 9:58
 */
return [
    // 发表主题帖的奖励
    'post_topic' => [
        'coin' => 1,
        'exp' => 3
    ],
    // 发表回复的奖励
    'post_reply' => [
        'coin' => 0,
        'exp' => 1
    ],
    // 各种操作的等级限制
    'level' => [
        'post_topic' => 0,
        'post_reply' => 0,
        'view_forum' => 0,
        'view_topic' => 0,
        'view_reply' => 0
    ],
    // 游客限制
    'guest' => [
        'view_forum' => true,
        'view_topic' => true,
        'view_reply' => true
    ]
];
