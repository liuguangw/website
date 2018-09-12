<?php
/**
 * Created by PhpStorm.
 * User: liuguang
 * Date: 2018/8/17
 * Time: 14:01
 */

namespace App\Http\Controllers;


use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * 默认要求登录
     *
     * @return bool
     */
    protected function needLogin()
    {
        return true;
    }

    protected function useAuthMiddleware()
    {
        //排除不需要登录的方法
        parent::useAuthMiddleware()->except(['login', 'register', 'doLogin', 'doRegister']);
        //只能游客身份访问的方法
        $this->middleware('guest')->only(['login', 'register', 'doLogin', 'doRegister']);
    }

    public function index()
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        return $user;
    }

    /**
     * 展示登录页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if ($request->query->has('back')) {
            $prevUrl = url()->previous();
            if (!empty($prevUrl)) {
                Session::put('url.intended', $prevUrl);
            }
        }
        return view('user.login', ['defaultAction' => 'login']);
    }

    public function register()
    {
        return view('user.login', ['defaultAction' => 'register']);
    }

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function guard()
    {
        return Auth::guard();
    }

    private function username()
    {
        return 'username';
    }

    /**
     * 登录尝试
     *
     * @param Request $request
     * @return bool
     */
    private function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $request->only($this->username(), 'password'), $request->filled('remember')
        );
    }

    /**
     * 无来源url的默认跳转地址
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('userHome');
    }

    /**
     * 登录成功的响应
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        return redirect()->intended($this->redirectPath());
    }

    /**
     * 登录失败的响应
     *
     * @param Request $request
     * @return void
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'password' => ['密码错误']
        ]);
    }

    /**
     * 处理用户登录
     *
     * @param UserLogin $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function doLogin(UserLogin $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        $this->sendFailedLoginResponse($request);
    }

    public function doRegister(UserRegister $request)
    {
        $user = new User();
        $user->fill($request->request->all());
        $user->password = Hash::make($user->password);
        if ($user->save()) {
            Auth::loginUsingId($user->id);
            return redirect()->route('userHome');
        }
    }

    /**
     * 修改密码页面
     * @todo
     */
    public function modifyPassword()
    {
        return 'modifyPassword page';
    }

    public function doModifyPassword()
    {
        return ['code' => '-1'];
    }
}
