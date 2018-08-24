<tr>
    <td class="topic-node-icon">
        <a href="">
            @if($topicInfo->t_locked)
                <img src="{{ asset('images/default/topic_icon_lock.png') }}" alt=""/>
            @elseif($topicInfo->is_today_post)
                <img src="{{ asset('images/default/topic_icon_new.png') }}" alt=""/>
            @else
                <img src="{{ asset('images/default/topic_icon_common.png') }}" alt=""/>
            @endif
        </a>
    </td>
    <td class="topic-node-title"><a href="">{{ $topicInfo->title }}</a></td>
    <td class="topic-node-author">
        <a href="">{{ $topicInfo->author->nickname }}</a>
        <span>2018-6-22</span>
    </td>
    <td class="topic-node-count">
        <a href="">{{ $topicInfo->reply_count }}</a>
        <span>{{ $topicInfo->view_count }}</span>
    </td>
    <td class="topic-node-last-post">
        <a href="">{{ $topicInfo->author->nickname }}</a>
        <span>4天前</span>
    </td>
</tr>
