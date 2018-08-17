@extends('layouts.login')
@section('title', '登录/注册')
@section('content')
    <div class="main-container">
        <div class="form-warp">
            <!-- start login form -->
            <div id="login" class="login-form" @if ($defaultAction != 'login')
            style="display: none"
                @endif>
                <form method="post" action="{{ action('UserController@doLogin') }}">
                    @csrf
                    <h2>用户登录</h2>
                    <fieldset class="fields1">
                        <div>
                            <label>用户名</label>
                            <input class="inputbox" type="text" name="username" autocomplete="off"/>
                        </div>
                        <div>
                            <label>密码</label>
                            <input class="inputbox" type="password" name="password" autocomplete="off"/>
                        </div>
                        <div>
                            <label><input type="checkbox" name="remember" value="1" checked="checked" class="check-input"/>记住我</label>
                        </div>
                        <input class="button" type="submit" value="登录"/>
                    </fieldset>
                    <div class="links-area">
                        <a href="{{ action('UserController@register') }}" id="showRegFormBtn">立即注册</a>
                        <span>|</span>
                        <a href="">忘记密码</a>
                    </div>
                </form>
            </div>
            <!-- end login form -->
            <!-- start reg form -->
            <div id="register" class="login-form" @if ($defaultAction != 'register')
            style="display: none"
                @endif>
                <form method="post" action="{{ action('UserController@doRegister') }}">
                    @csrf
                    <h2>用户注册</h2>
                    <fieldset class="fields1">
                        <div>
                            <label>用户名</label>
                            <input class="inputbox" type="text" name="username" autocomplete="off"/>
                        </div>
                        <div>
                            <label>昵称</label>
                            <input class="inputbox" type="text" name="nickname" autocomplete="off"/>
                        </div>
                        <div>
                            <label>邮箱</label>
                            <input class="inputbox" type="email" name="email" autocomplete="off"/>
                        </div>
                        <div>
                            <label>密码</label>
                            <input class="inputbox" type="password" name="pass1" autocomplete="off"/>
                        </div>
                        <div>
                            <label>再次输入密码</label>
                            <input class="inputbox" type="password" name="pass2" autocomplete="off"/>
                        </div>
                        <input class="button" type="submit" value="注册"/>
                    </fieldset>
                    <div class="links-area">
                        <a href="{{ action('UserController@login') }}" id="showLoginFormBtn">立即登录</a>
                        <span>|</span>
                        <a href="">忘记密码</a>
                    </div>
                </form>
            </div>
            <!-- end reg form -->
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        (function () {
            var fadeInAnimated = "animated faster pulse",
                fadeOutAnimated = "animated faster bounceOutLeft";
            var formItems = [document.getElementById("register"), document.getElementById("login")];
            var btns = [document.getElementById("showRegFormBtn"), document.getElementById("showLoginFormBtn")];
            for (var btnIndex in btns) {

                /*为a标签分别绑定点击事件*/
                (function (btn, showForm, hideForm) {
                    btn.addEventListener("click", function (e) {
                        /*阻止a标签默认行为*/
                        e.preventDefault();
                        /*hide*/
                        hideForm.className = "login-form " + fadeOutAnimated;
                        setTimeout(function () {
                            hideForm.style.display = "none";
                            hideForm.className = "login-form";
                            /*show*/
                            showForm.className = "login-form " + fadeInAnimated;
                            showForm.style.display = "block";
                        }, 500);
                    })
                })(btns[btnIndex], formItems[btnIndex], formItems[1 - btnIndex]);

            }
        })();
    </script>
@endsection
