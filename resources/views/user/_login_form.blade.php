<form method="post" action="{{ action('UserController@doLogin') }}">
    @csrf
    <h2>用户登录</h2>
    @if ($defaultAction == 'login')
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
            <div class="captcha-nav clearfix">
                <div class="captcha-nav-image">
                    @if ($defaultAction == 'login')
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
