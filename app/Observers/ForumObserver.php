<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/29
 * Time: 12:17
 */

namespace App\Observers;


use App\Models\Forum;

class ForumObserver
{
    public function creating(Forum $forum)
    {
        $forum->today_updated_at = now();
    }
}
