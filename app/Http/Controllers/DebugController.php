<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/9/12
 * Time: 18:34
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class DebugController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            Auth::loginUsingId(1, true);
        }
        return Auth::user()->toArray();
    }
}
