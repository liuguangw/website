<div class="post-meta">
    <a class="floor-num" href="">
        <span style="color: red;">楼主</span>
    </a>
    <span>发表于 {{ $topic->post_time }}</span>
</div>
@if($topic->t_disabled)
    <div class="post-disbaled">提示: 此内容已被管理员屏蔽</div>
@else
    @if($topic->last_modify_time!==null)
        <div class="post-modify-tip">本帖最后由 {{ $topic->author->nickname }} 于 {{ $topic->last_modify_time }} 编辑</div>
    @endif
    <div class="post-content">{{ $topic->topicContent->content }}</div>
    @if($topic->t_locked)
        <div class="post-locked">提示: 帖子已被锁定不允许回复</div>
    @endif
@endif
