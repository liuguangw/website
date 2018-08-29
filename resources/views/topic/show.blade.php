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
    <div class="forum-topic-warp">
        <table>
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
                        <h1>{{ $topic->title }}</h1>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="left-side">
                    @component('components.post_author',['author'=>$topicAuthor])
                    @endcomponent
                </td>
                <td>
                    <div class="post-detail">
                        <div class="post-meta">
                            <span>发表于{{ $topic->post_time }}</span>
                        </div>
                        <div class="post-content">{{ $content }}</div>
                    </div>
                </td>
            </tr>
            @if(!$replies->isEmpty())
                @foreach($replies as $replyInfo)
                    <tr>
                        <td class="left-side">
                            @component('components.post_author',['author'=>$replyInfo->author])
                            @endcomponent
                        </td>
                        <td>
                            <div class="post-detail">
                                <div class="post-meta">
                                    <a class="floor-num" href=""><em>{{ $replyInfo->floor_id }}</em><sup>#</sup></a>
                                    <span>发表于{{ $replyInfo->created_at }}</span>
                                </div>
                                <div class="post-content">{{ $replyInfo->content }}</div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
@endsection
