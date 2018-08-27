<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/24
 * Time: 16:38
 */

namespace App\Services;


use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorService
{
    /**
     * 分页数据获取
     * @param LengthAwarePaginator $paginator
     * @param callable $urlMaker
     * @param array $params 附加url参数
     * @param string $fragment 锚链接
     * @return array
     */
    public function links(LengthAwarePaginator $paginator, $urlMaker, $params = [], $fragment = '')
    {
        $result = [
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'first_page_url' => call_user_func($urlMaker, 1, $params, $fragment),
            'last_page_url' => call_user_func($urlMaker, $paginator->lastPage(), $params, $fragment),
            'prev_page_url' => null,
            'next_page_url' => null,
            'items' => [

            ],
            'from_page' => 0,
            'to_page' => 0
        ];
        if ($result['lastPage'] < 2) {
            //无分页
            return $result;
        }
        if ($result['currentPage'] > 1) {
            $result['prev_page_url'] = call_user_func($urlMaker, $result['currentPage'] - 1, $params, $fragment);
        }
        if ($result['currentPage'] < $result['lastPage']) {
            $result['next_page_url'] = call_user_func($urlMaker, $result['currentPage'] + 1, $params, $fragment);
        }
        $pageContext = 5;
        $result['from_page'] = $result['currentPage'] - $pageContext;
        $result['to_page'] = $result['currentPage'] + $pageContext;
        if ($result['from_page'] < 1) {
            $result['to_page'] += 1 - $result['from_page'];
            $result['from_page'] = 1;
            if ($result['to_page'] > $result['lastPage']) {
                $result['to_page'] = $result['lastPage'];
            }
        }
        if ($result['to_page'] > $result['lastPage']) {
            $result['from_page'] -= $result['to_page'] - $result['lastPage'];
            $result['to_page'] = $result['lastPage'];
            if ($result['from_page'] < 1) {
                $result['from_page'] = 1;
            }
        }
        for ($i = $result['from_page']; $i <= $result['to_page']; $i++) {
            $result['items']['#page' . $i] = call_user_func($urlMaker, $i, $params, $fragment);
        }
        return $result;
    }
}
