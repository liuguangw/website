@php
    if(empty($forum)){
        $forum = $topicInfo->forum;
    }
@endphp
<tr>
    <td class="topic-node-icon">
        <a href="">
            @if(($topicInfo->order_id>1)&&($topicOrder=='common'))
                <img src="{{ asset('images/default/topic_icon_top.gif') }}" alt=""/>
            @elseif($topicInfo->t_locked)
                <img src="{{ asset('images/default/topic_icon_lock.png') }}" alt=""/>
            @elseif($topicInfo->is_today_post)
                <img src="{{ asset('images/default/topic_icon_new.png') }}" alt=""/>
            @else
                <img src="{{ asset('images/default/topic_icon_common.png') }}" alt=""/>
            @endif
        </a>
    </td>
    <td class="topic-node-title">
        @if($topicInfo->topicType!==null)
            <span>[</span>
            <a class="topic-node-type"
               href="{{ $forum->link(['type'=>$topicInfo->topicType->id]) }}"
               @if($topicInfo->topicType->color!='')
               style="color: {{ $topicInfo->topicType->color }};"
                @endif
            >{{ $topicInfo->topicType->name }}</a>
            <span>]</span>
        @endif
        <a href="{{ $topicInfo->link() }}"
           @if($topicInfo->color!='')
           style="color:{{ $topicInfo->color }};"
            @endif
        >{{ $topicInfo->title }}</a></td>
    <td class="topic-node-author">
        <a href=""
           @if($topicInfo->color!='')
           style="color:{{ $topicInfo->color }};"
            @endif
        >{{ $topicInfo->author->nickname }}</a>
        <span>{{ $topicInfo->formatTime($topicInfo->post_time) }}</span>
    </td>
    <td class="topic-node-count">
        <a href="{{ $topicInfo->link() }}">{{ $topicInfo->reply_count }}</a>
        <span>{{ $topicInfo->view_count }}</span>
    </td>
    <td class="topic-node-last-post">
        <a href="">
            @if($topicInfo->lastReplyUser===null)
                -
            @else
                {{ $topicInfo->lastReplyUser->nickname }}
            @endif
        </a>
        <span>
            @if($topicInfo->reply_time===null)
                -
            @else
                {{ $topicInfo->formatTime($topicInfo->reply_time) }}
            @endif
        </span>
    </td>
</tr>
