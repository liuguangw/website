@extends('layouts.main')
@section('title', 'forum -'.$forum->name)
@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">首页</a></li>
            <li class="sep">&rsaquo;</li>
            <li><a href="{{ $forum->forumGroup->link() }}">{{ $forum->forumGroup->name }}</a></li>
            @unless ($forum->is_root)
                @foreach($forum->parentForums as $pForum)
                    <li class="sep">&rsaquo;</li>
                    <li><a href="{{ $pForum->link() }}">{{ $pForum->name }}</a></li>
                @endforeach
            @endunless
            <li class="sep">&rsaquo;</li>
            <li>{{ $forum->name }}</li>
        </ul>
    </div>
    <div class="forum-box">
        <div class="forum-header">{{ $forum->name }}</div>
        <div class="forum-admin-list">版主: <a
                href="#"><strong>民审K星客</strong></a>, <a
                href="#"><strong>民审-小源</strong></a>, <a
                href="#"><strong>民审大大</strong></a>, <a
                href="#"><strong>民审员乙</strong></a>, <a
                href="#"><strong>民审x</strong></a>
        </div>
        <div class="forum-intro">
            <p>1. 本版讨论xxx的插件开发、安装、使用、需求、问题反馈。发布其他无关内容将直接删帖，并根据情节轻重进行积分扣减、警告，直至禁言或封杀帐号。<br>
                2. <span
                    style="color:#ff0000">发帖请严格按照分类进行发帖，插件发布帖严格要求上传插件或提供应用中心下载地址</span>，分类错误将直接删帖，情节严重者将受到更严重的处罚。<br>
                3. 对于有严重缺陷或者问题并直接威胁论坛安全的插件，官方接到举报后，将对该插件发布贴停止浏览或屏蔽，直至插件补丁发布并且附件更新。<br>
                4. 安装插件有风险,xxxx官方、团队不对因安装插件产生的任何后果(如不良影响)负责<br>
                5. 插件的版权归插件作者所有, 尊重作者是基本的道德。<span style="color:#ff0000">禁止诋毁、抄袭、盗用版权或未经作者同意转载、转发插件作品的行为</span>，情节严重者永久封闭帐号。<br>
                6. 鼓励网友积极对喜欢的插件和优秀的插件进行评分，大家的评分是插件作者继续前进的动力，版主也<span
                    style="color:#ff0000">将对优秀插件进行金币奖励和适当的高亮推荐</span>。<br>
                7. 其他未尽事宜，请随时关注版主的相关公告贴</p>
        </div>
    </div>
    <div class="forum-head-nav">
        <a class="post-btn" href="{{ $forum->createTopicLink() }}">发帖</a>
        <!--分页-->
        @component('components.pagination',['pagination'=>$pagination])
        @endcomponent
    </div>
    <div class="from-topic-types">
        @php
            $typeParams=$routeParams;
        @endphp
        <ul>
            @if($extraParams['type']=='all')
                <li class="active"><span>全部</span></li>
            @else
                <li><a href="{{ $forum->link() }}">全部</a></li>
            @endif
            @foreach($forum->topicTypes as $topicTypeInfo)
                @if($extraParams['type']==$topicTypeInfo->id)
                    <li class="active"
                        @if($topicTypeInfo->color!='')
                        style="color: {{ $topicTypeInfo->color }};"
                        @endif
                    ><span>{{ $topicTypeInfo->name }}<span class="num">{{ $topicTypeInfo->post_count }}</span></span>
                    </li>
                @else
                    <li><a href="{{ $forum->link(['type' => $topicTypeInfo->id]) }}"
                           @if($topicTypeInfo->color!='')
                           style="color: {{ $topicTypeInfo->color }};"
                            @endif
                        >{{ $topicTypeInfo->name }}<span class="num">{{ $topicTypeInfo->post_count }}</span></a></li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="forum-box">
        @php
            if($extraParams['type']!='all'){
                $routeParams['type']=$extraParams['type'];
            }
            $orderRouteParams=$filterParams=$routeParams;
            if($extraParams['order']!='common'){
                $filterParams['order']=$extraParams['order'];
            }
            if($extraParams['filter']!='all'){
                $orderRouteParams['filter']=$extraParams['filter'];
            }
            //clean
            if(isset($filterParams['filter'])){
                unset($filterParams['filter']);
            }
            if(isset($orderRouteParams['order'])){
                unset($orderRouteParams['order']);
            }
        @endphp
        <div class="forum-header">
            <table>
                <tr>
                    <td>
                        <span class="forum-order-title">排序</span>
                        <span class="sep">:</span>
                        @if($extraParams['order']=='common')
                            <span class="forum-order-link">默认</span>
                        @else
                            <a class="forum-order-link" href="{{ $forum->link($orderRouteParams) }}">默认</a>
                        @endif
                        <span class="sep">-</span>
                        @if($extraParams['order']=='latest')
                            <span class="forum-order-link">最新</span>
                        @else
                            <a class="forum-order-link"
                               href="{{ $forum->link(array_merge($orderRouteParams,['order'=>'latest'])) }}">最新</a>
                        @endif
                        <span class="sep">-</span>
                        @if($extraParams['order']=='hot')
                            <span class="forum-order-link">最热</span>
                        @else
                            <a class="forum-order-link"
                               href="{{ $forum->link(array_merge($orderRouteParams,['order'=>'hot'])) }}">最热</a>
                        @endif
                        <span class="sep-long">|</span>
                        <span class="forum-order-title">筛选</span>
                        <span class="sep">:</span>
                        @if($extraParams['filter']=='all')
                            <span class="forum-order-link">所有</span>
                        @else
                            <a class="forum-order-link" href="{{ $forum->link($filterParams) }}">所有</a>
                        @endif
                        <span class="sep">-</span>
                        @if($extraParams['filter']=='good')
                            <span class="forum-order-link">精华</span>
                        @else
                            <a class="forum-order-link"
                               href="{{ $forum->link(array_merge($filterParams,['filter'=>'good'])) }}">精华</a>
                        @endif
                        <span class="sep">-</span>
                        @if($extraParams['filter']=='top')
                            <span class="forum-order-link">顶置</span>
                        @else
                            <a class="forum-order-link"
                               href="{{ $forum->link(array_merge($filterParams,['filter'=>'top'])) }}">顶置</a>
                        @endif
                    </td>
                    <td class="forum-header-author">作者</td>
                    <td class="forum-header-count">回复/查看</td>
                    <td class="forum-header-reply">最后发表</td>
                </tr>
            </table>
        </div>
        <div class="forum-topic-list">
            @if($topics->isEmpty())
                <div>暂无帖子</div>
            @else
                <table class="topic-list">
                    @php
                        $needShowTopSep = false;
                    @endphp
                    @foreach($topics as $topicInfo)
                        @php
                            if(($extraParams['type']=='all')&&($extraParams['filter']=='all')&&($extraParams['order']=='common')&&($topicInfo->order_id>1)){
                                $needShowTopSep = true;
                            }
                        @endphp
                        @if( $needShowTopSep && ($topicInfo->order_id<=1) )
                            <tr>
                                <td class="topic-node-sep" colspan="5"></td>
                            </tr>
                            @php
                                $needShowTopSep = false;
                            @endphp
                        @endif
                        @component('components.topic_list_node',['forum'=>$forum,'topicInfo'=>$topicInfo,'topicOrder'=>$extraParams['order']])
                        @endcomponent
                    @endforeach
                </table>
            @endif
        </div>
    </div>
    @if(!$forum->childForums->isEmpty())
        <div class="forum-group-list">
            <div class="forum-group">
                <div class="forum-group-title"><a href="javascript:void(0)">子论坛</a></div>
                @php
                    $forums=$forum->childForums->load('avatarFile');
                @endphp
                @component('components.forum_group_wlist',['forums'=>$forums])
                @endcomponent
            </div>
        </div>
    @endif
    <!--分页-->
    @component('components.pagination',['pagination'=>$pagination])
    @endcomponent
@endsection
