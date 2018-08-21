<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserController;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPasswordModify
{
    /**
     * 处理need_modify_password属性
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            /**
             * @var \App\Models\User $user
             */
            $user = Auth::user();
            //强制要求修改密码
            if ($user->need_modify_password) {
                $action = $request->route()->getActionName();
                //忽略修改密码的action
                $skipActions = [
                    UserController::class . '@modifyPassword',
                    UserController::class . '@doModifyPassword'
                ];
                //强制跳转到修改密码页面
                if (!in_array($action, $skipActions)) {
                    return redirect()->action(
                        'UserController@modifyPassword', ['force' => 1]
                    );
                }
            }
        }
        return $next($request);
    }
}
