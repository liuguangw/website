<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/28
 * Time: 16:00
 */

namespace App\Traits;


use Illuminate\Support\Carbon;

trait TimeFormatTrait
{
    public function formatTime(Carbon $opTime)
    {
        $timeNow = now();
        $result = $timeNow->toDateString();
        $tmp = $timeNow->diffInSeconds($opTime);
        if ($tmp < 5) {
            return '刚刚';
        } elseif ($tmp < 60) {
            return $tmp . '秒前';
        }
        $tmp = $timeNow->diffInMinutes($opTime);
        if ($tmp < 60) {
            return $tmp . '分钟前';
        }
        $tmp = $timeNow->diffInHours($opTime);
        if ($tmp < 24) {
            return $tmp . '小时前';
        }
        $tmp = $timeNow->diffInDays($opTime);
        $result = $tmp . '天前';
        if ($tmp < 30) {
            return $result;
        }
        $monthDiff = $timeNow->diffInMonths($opTime);
        if ($monthDiff == 0) {
            return $result;
        } elseif ($monthDiff < 6) {
            return $monthDiff . '个月前';
        } elseif ($monthDiff < 12) {
            return '半年前';
        }
        $tmp = $timeNow->diffInYears($opTime);
        return $tmp . '年前';
    }
}
