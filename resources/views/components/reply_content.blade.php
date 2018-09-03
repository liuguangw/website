<div class="post-meta">
    <a class="floor-num" href=""><em>{{ $replyInfo->floor_id }}</em><sup>#</sup></a>
    <span>发表于 {{ $replyInfo->created_at }}</span>
</div>
@if($replyInfo->t_disabled)
    <div class="post-disbaled">提示: 此内容已被管理员屏蔽</div>
@else
    <div class="post-content">{{ $replyInfo->content }}</div>
@endif
