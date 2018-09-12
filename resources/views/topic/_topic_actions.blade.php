{{-- 帖子或者回复的可用操作 --}}
@unless($topic->t_locked)
    @auth
        <span class="action-item">
            <a class="action-reply" href="javascript:void(0);" onclick="showReplyDialog(0)">回复</a>
        </span>
    @elseguest
        <span class="action-item">
            <a class="action-reply" href="{{ $loginUrl }}">回复</a>
        </span>
    @endauth
@endunless
<span class="action-item">
    @auth
        @if(empty($postItem->likeLog))
            {{-- 没有选择支持或者反对--}}
            <a class="action-like" href="javascript:void(0);" onclick="likePost({{ $postItem->id }},true)">支持 0</a>
        @elseif($postItem->likeLog->is_like)
            {{-- 已支持 --}}
            <a class="action-like" href="javascript:void(0);" onclick="cancelLikePost({{ $postItem->id }})">支持 0</a>
        @else
            {{-- 已反对 --}}
            <a class="action-like" href="javascript:void(0);" onclick="likePost({{ $postItem->id }})">支持 0</a>
        @endif
    @elseguest
        <a class="action-like" href="{{ $loginUrl }}">支持 0</a>
    @endauth
</span>
<span class="action-item">
    @auth
        @if(empty($postItem->likeLog))
            {{-- 没有选择支持或者反对--}}
            <a class="action-like" href="javascript:void(0);" onclick="unlikePost({{ $postItem->id }},true)">反对 0</a>
        @elseif($postItem->likeLog->is_like)
            {{-- 已支持 --}}
            <a class="action-like" href="javascript:void(0);" onclick="unlikePost({{ $postItem->id }})">反对 0</a>
        @else
            {{-- 已反对 --}}
            <a class="action-like" href="javascript:void(0);" onclick="cancelUnlikePost({{ $postItem->id }})">反对 0</a>
        @endif
    @elseguest
        <a class="action-like" href="{{ $loginUrl }}">支持 0</a>
    @endauth
</span>
