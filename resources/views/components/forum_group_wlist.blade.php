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
                        <a href="#">应用中心ID被屏蔽了 附：致开发 ...</a>
                        <div>昨天 13:06 <a
                                href="#">8641340</a></div>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
