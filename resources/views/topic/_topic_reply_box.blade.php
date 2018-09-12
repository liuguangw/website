{{--  帖子底部回帖区域 --}}
<div class="forum-box">
    <table class="reply-box">
        <tr>
            <td class="current-user">
                <div class="current-user-avatar">
                    @auth
                        <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_url }}" alt="头像"/>
                    @elseguest
                        <img src="{{ asset('images/default/user_avatar.png') }}" alt="头像"/>
                    @endauth
                </div>
            </td>
            <td class="user-input">
                <form method="post" action="{{ action('ReplyController@store') }}">
                    @csrf
                    <input type="hidden" name="to_floor_id" value="0"/>
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}"/>
                    <div class="box-input-warp">
                        @auth
                            <textarea name="content">{{ old('content','') }}</textarea>
                        @elseguest
                            <div class="login-tip"><span>您需要登录后才可以回帖</span> <a href="{{ $loginUrl }}">登录</a>
                                <span> | </span> <a href="{{ route('register') }}">立即注册</a></div>
                        @endauth
                    </div>
                    @auth
                        <div class="box-captcha">
                            <span>验证码</span>
                            <input type="text" name="captcha_code" value="" placeholder="输入验证码"
                                   autocomplete="off"/>
                            <a href="javascript:void(0)">换一个</a>
                            <div class="reply-captcha-warp" style="display: none;">
                                <div>请输入下图中的字符</div>
                                <div><img src="{{ asset('images/loading.gif') }}" alt="验证码"/></div>
                            </div>
                        </div>
                    @endauth
                    <div class="input-footer">
                        <a href="">本版积分规则</a>
                        @auth
                            <button class="btn" type="submit">发表回复</button>
                        @elseguest
                            <a class="btn" href="{{ $loginUrl }}">发表回复</a>
                        @endauth
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
