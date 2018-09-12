{{-- 帖子分页区 --}}
<div class="topic-reply-btns clearfix">
    <div class="btns">
        <a class="btn-post" href="{{ action('TopicController@create',['id'=>$forum->id]) }}">发帖</a>
        @unless($topic->t_locked)
            @auth
                <a class="btn-reply" href="javascript:void(0);" onclick="showReplyDialog(0)">回复</a>
            @elseguest
                <a class="btn-reply" href="{{ $loginUrl}}">回复</a>
            @endauth
        @endunless
    </div>
    <!--分页-->
    @component('components.pagination',['pagination'=>$pagination])
    @endcomponent
</div>
