<form method="post" action="{{ action('UserController@doRegister') }}">
    @csrf
    <h2>用户注册</h2>
    @if ($defaultAction == 'register')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif

    <fieldset class="fields1">
        <div>
            <label>用户名</label>
            <input
                @if ($errors->has('username'))
                class="inputbox error-input"
                @else
                class="inputbox"
                @endif
                type="text" name="username" value="{{ old('username','') }}" autocomplete="off"/>
        </div>
        <div>
            <label>昵称</label>
            <input
                @if ($errors->has('nickname'))
                class="inputbox error-input"
                @else
                class="inputbox"
                @endif
                type="text" name="nickname" value="{{ old('nickname','') }}" autocomplete="off"/>
        </div>
        <div>
            <label>邮箱</label>
            <input
                @if ($errors->has('email'))
                class="inputbox error-input"
                @else
                class="inputbox"
                @endif
                type="email" name="email" value="{{ old('email','') }}" autocomplete="off"/>
        </div>
        <div>
            <label>密码</label>
            <input
                @if ($errors->has('password'))
                class="inputbox error-input"
                @else
                class="inputbox"
                @endif
                type="password" name="password" autocomplete="off"/>
        </div>
        <div>
            <label>再次输入密码</label>
            <input class="inputbox" type="password" name="password_confirmation" autocomplete="off"/>
        </div>
        <div>
            <div class="captcha-nav clearfix">
                <div class="captcha-nav-image">
                    @if ($defaultAction == 'register')
                        <img src="{{ route('captcha') }}" alt="图形验证码" title="点击刷新"/>
                    @else
                        <img src="{{ asset('images/loading.gif') }}" alt="图形验证码" title="点击刷新"/>
                    @endif
                </div>
                <div class="captcha-nav-input">
                    <label>验证码</label>
                    <input
                        @if ($errors->has('captcha_code'))
                        class="inputbox error-input"
                        @else
                        class="inputbox"
                        @endif
                        type="text" name="captcha_code" autocomplete="off"/>
                </div>
            </div>
        </div>
        <input class="button" type="submit" value="注册"/>
    </fieldset>
    <div class="links-area">
        <a href="{{ action('UserController@login') }}" id="showLoginFormBtn">立即登录</a>
        <span>|</span>
        <a href="">忘记密码</a>
    </div>
</form>
