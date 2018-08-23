<div class="forum-group">
    <div class="forum-group-title"><a href="{{ $groupInfo->link() }}">{{ $groupInfo->name }}</a></div>
    @php
        $forums=$groupInfo->childForums->load('avatarFile');
    @endphp
    @if($forums->isEmpty())
        <div class="forums">暂无子论坛</div>
    @else
        @component('components.forum_group_wlist',['forums'=>$forums])
        @endcomponent
    @endif
</div>
