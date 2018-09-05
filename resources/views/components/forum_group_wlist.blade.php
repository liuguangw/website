<div class="forums forums-w">
    <table>
        @foreach($forums as $forumInfo)
            <tr>
                <td>
                    <div class="forum-icon">
                        <a href="{{ $forumInfo->link() }}">
                            <img src="{{ $forumInfo->avatar_url }}"
                                 alt="{{ $forumInfo->name }}"/>
                        </a>
                    </div>
                </td>
                <td>

                    <div class="forum-detail">
                        <div class="forum-name">
                            <a href="{{ $forumInfo->link() }}"
                               @if($forumInfo->color!='')
                               style="color:{{ $forumInfo->color }};"
                                @endif
                            >{{ $forumInfo->name }}</a>
                            @if($forumInfo->today_post_count>0)
                                <span>({{ $forumInfo->today_post_count }})</span>
                            @endif
                        </div>
                        @if($forumInfo->description !='')
                            <div>{{ $forumInfo->description }}</div>
                        @endif
                        <div class="forum-latest-post">版主: <a
                                href="#"><strong>民审K星客</strong></a>, <a
                                href="#"><strong>民审-小源</strong></a>, <a
                                href="#"><strong>民审大大</strong></a>, <a
                                href="#"><strong>民审员乙</strong></a>, <a
                                href="#"><strong>民审x</strong></a>
                        </div>
                        @if($forumInfo->description =='')
                            <div></div>
                        @endif
                    </div>

                </td>
                <td class="count-nav">
                    <span class="c1">{{ $forumInfo->post_count }}</span>
                    <span class="c2"> / </span>
                    <span class="c2">{{ $forumInfo->reply_count }}</span>
                </td>
                <td class="last-post-nav">
                    <div class="forum-latest-post">
                        @if($forumInfo->last_post_type!==0)
                            <a href="{{ $forumInfo->lastTopic->link() }}">{{ $forumInfo->lastTopic->title }}</a>
                            <div>{{ $forumInfo->formatTime($forumInfo->last_post_time ) }} <a
                                    href="#">{{ $forumInfo->lastPostUser->nickname }}</a></div>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
