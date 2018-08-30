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
            <li><a href="{{ $forum->link() }}">{{ $forum->name }}</a></li>
            <li class="sep">&rsaquo;</li>
            <li><a href="{{ $topic->link() }}" style="color: #333;">{{ $topic->title }}</a></li>
        </ul>
    </div>
    <pre>
        @php
            dump($topic->toArray());
        @endphp
    </pre>
    <div class="topic-reply-btns clearfix">
        <div class="btns">
            <a class="btn-post" href="{{ action('TopicController@create',['id'=>$forum->id]) }}">发帖</a>
            <a class="btn-reply" href="javascript:void(0);" onclick="showReplyDialog(0)">回复</a>
        </div>
        <!--分页-->
        @component('components.pagination',['pagination'=>$pagination])
        @endcomponent
    </div>
    <div class="forum-topic-warp">
        <table class="post-list">
            <tr>
                <td class="left-side">
                    <div class="topic-info">
                        <span class="t-text">查看</span>
                        <span class="t-num">{{ $topic->view_count }}</span>
                        <span class="t-sep">|</span>
                        <span class="t-text">回复</span>
                        <span class="t-num">{{ $topic->reply_count }}</span>
                    </div>
                </td>
                <td>
                    <div class="topic-title">
                        @if($topicType!==null)
                            <span>[</span>
                            <a class="topic-type-link"
                               @if($topicType->color!='')
                               style="color:{{ $topicType->color }};"
                               @endif
                               href="{{ $forum->link(['type'=>$topicType->id]) }}">{{ $topicType->name }}</a>
                            <span>]</span>
                        @endif
                        <h1>{{ $topic->title }}</h1>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="sep1"></td>
                <td class="sep2"></td>
            </tr>
            @if($page==1)
                <tr>
                    <td class="left-side">
                        @component('components.post_author',['author'=>$topicAuthor])
                        @endcomponent
                    </td>
                    <td>
                        <div class="post-detail">
                            <div class="post-meta">
                                <a class="floor-num" href=""><span style="color: red;">楼主</span></a>
                                <span>发表于 {{ $topic->post_time }}</span>
                            </div>
                            @if($topic->last_modify_time!==null)
                                <div class="post-modify-tip">本帖最后由 {{ $topicAuthor->nickname }}
                                    于 {{ $topic->last_modify_time }} 编辑
                                </div>
                            @endif
                            <div class="post-content">{{ $content }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="left-side"></td>
                    <td class="action-nav-warp">
                        <div class="action-nav">
                        <span class="action-item">
                             <a class="action-reply" href="javascript:void(0);" onclick="showReplyDialog(0)">回复</a>
                        </span>
                        </div>
                    </td>
                </tr>
            @endif
            @if(!$replies->isEmpty())
                @foreach($replies as $replyInfo)
                    <tr>
                        <td class="sep1"></td>
                        <td class="sep2"></td>
                    </tr>
                    <tr>
                        <td class="left-side">
                            @component('components.post_author',['author'=>$replyInfo->author])
                            @endcomponent
                        </td>
                        <td>
                            <div class="post-detail">
                                <div class="post-meta">
                                    <a class="floor-num" href=""><em>{{ $replyInfo->floor_id }}</em><sup>#</sup></a>
                                    <span>发表于 {{ $replyInfo->created_at }}</span>
                                </div>
                                <div class="post-content">{{ $replyInfo->content }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-side"></td>
                        <td class="action-nav-warp">
                            <div class="action-nav">
                                <span class="action-item">
                                    <a class="action-reply" href="javascript:void(0);"
                                       onclick="showReplyDialog({{ $replyInfo->floor_id }})">回复</a>
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    <div class="topic-reply-btns clearfix">
        <div class="btns">
            <a class="btn-post" href="{{ action('TopicController@create',['id'=>$forum->id]) }}">发帖</a>
            <a class="btn-reply" href="javascript:void(0);" onclick="showReplyDialog(0)">回复</a>
        </div>
        <!--分页-->
        @component('components.pagination',['pagination'=>$pagination])
        @endcomponent
    </div>
    <table class="dialog reply-dialog" cellpadding="0" cellspacing="0" style="display: none;">
        <tr>
            <td class="dialog-border b-topleft"></td>
            <td class="dialog-border b-top"></td>
            <td class="dialog-border b-topright"></td>
        </tr>
        <tr>
            <td class="dialog-border b-left"></td>
            <td>
                <div class="dialog-warp">
                    <a class="dialog-close-icon" href="javascript:void(0)" onclick="hideDialog(this);"></a>
                    <h3>参与/回复主题</h3>
                    <div class="re-text"></div>
                    <div class="reply-edit">
                        <textarea></textarea>
                    </div>
                </div>
                <div class="dialog-footer">
                    <a href="">本版积分规则</a>
                    <button class="dialog-btn" type="button">参与/回复主题</button>
                </div>
            </td>
            <td class="dialog-border b-right"></td>
        </tr>
        <tr>
            <td class="dialog-border b-bottomleft"></td>
            <td class="dialog-border b-bottom"></td>
            <td class="dialog-border b-bottomright"></td>
        </tr>
    </table>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript">
        var fadeInAnimated = "animated faster pulse",
            fadeOutAnimated = "animated faster bounceOutLeft";
        var dialogEl = document.getElementsByClassName("reply-dialog").item(0);
        bindDragEvent(dialogEl);

        function showReplyDialog() {
            if (dialogEl.style.display == "none") {
                dialogEl.style.left = (window.innerWidth - 638) / 2 + "px";
                dialogEl.className += (" " + fadeInAnimated);
                dialogEl.style.display = "table";
            }
        }

        function hideDialog(closeBtn) {
            var oDialog = closeBtn;
            while (oDialog.tagName.toLowerCase() != "table") {
                oDialog = oDialog.parentNode;
            }
            oDialog.style.display = "none";
        }
    </script>
@endsection
