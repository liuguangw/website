<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if ($this->needLogin()) {
            $this->useAuthMiddleware();
        }
    }


    /**
     * 判断用户是否需要登录
     *
     * @return bool
     */
    protected function needLogin()
    {
        return false;
    }

    /**
     * 使用auth中间件
     *
     * @return \Illuminate\Routing\ControllerMiddlewareOptions
     */
    protected function useAuthMiddleware()
    {
        return $this->middleware('auth');
    }
}
