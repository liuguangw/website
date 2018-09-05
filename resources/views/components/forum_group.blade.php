<div class="forum-group">
    <div class="forum-group-title"><a href="{{ $groupInfo->link() }}">{{ $groupInfo->name }}</a></div>
    @php
        $forums=$groupInfo->childForums->load(['avatarFile','lastPostUser','lastTopic'])->chunk(2);
    @endphp
    @if($forums->isEmpty())
        <div class="forums">暂无子论坛</div>
    @else
        <div class="forums">
            <table>
                @foreach($forums as $forumsRow)
                    <tr>
                        @foreach($forumsRow as $forumInfo)
                            <td>

                                <div class="forum-icon">
                                    <a href="{{ $forumInfo->link() }}">
                                        <img src="{{ $forumInfo->avatar_url }}"
                                             alt="{{ $forumInfo->name }}"/>
                                    </a>
                                </div>
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
                                    <div>主题 {{ $forumInfo->post_count }} ,回复 {{ $forumInfo->reply_count }}</div>
                                    <div class="forum-latest-post">
                                        <!--最后活动的帖子-->
                                        @if($forumInfo->last_post_type!==0)
                                            <a href="{{ $forumInfo->lastTopic->link() }}">{{ $forumInfo->lastTopic->title }}</a> {{ $forumInfo->formatTime($forumInfo->last_post_time ) }} <a
                                                href="#">{{ $forumInfo->lastPostUser->nickname }}</a>
                                        @endif
                                    </div>
                                </div>

                            </td>
                        @endforeach
                        @php
                            $padCount=2-$forumsRow->count();
                        @endphp
                        @if($padCount>0)
                            @for($i=0;$i<$padCount;$i++)
                                <td></td>
                            @endfor
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    @endif
</div>
