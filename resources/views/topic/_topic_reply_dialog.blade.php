{{-- 回帖弹框 --}}
@component('components.dialog',['extClass'=>' reply-dialog'])
    <form method="post" action="{{ action('ReplyController@store') }}">
        @csrf
        <div class="dialog-warp">
            <a class="dialog-close-icon" href="javascript:void(0)" onclick="closeDialog(this);"></a>
            <h3>参与/回复主题</h3>
            <input type="hidden" name="to_floor_id" value="0"/>
            <input type="hidden" name="topic_id" value="{{ $topic->id }}"/>
            <div class="reply-edit">
                <textarea name="content"></textarea>
            </div>
            <div class="reply-captcha">
                <span>验证码</span>
                <input type="text" name="captcha_code" value="" placeholder="输入验证码" autocomplete="off"/>
                <a href="javascript:void(0)">换一个</a>
                <div class="reply-captcha-warp" style="display: none;">
                    <div>请输入下图中的字符</div>
                    <div><img src="{{ asset('images/loading.gif') }}" alt="验证码"/></div>
                </div>
            </div>
        </div>
        <div class="dialog-footer">
            <a href="">本版积分规则</a>
            <button class="dialog-btn" type="submit">参与/回复主题</button>
        </div>
    </form>
@endcomponent
