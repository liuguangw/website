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
            <li>发表帖子</li>
        </ul>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="{{ $actionUrl }}">
        @csrf
        <input type="hidden" name="forum_id" value="{{ $forum->id }}"/>
        <div class="topic-title-edit clearfix">
            <div class="types-warp">
                <select name="topic_type"
                        @if ($errors->has('topic_type'))
                        class="error"
                    @endif
                >
                    <option value="0">请选择类别</option>
                    @foreach($forum->topicTypes as $topicTypeInfo)
                        <option value="{{ $topicTypeInfo->id }}">{{ $topicTypeInfo->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="title-warp">
                <input type="text"
                       @if ($errors->has('title'))
                       class="error"
                       @endif
                       name="title" value="{{ old('title','') }}" placeholder="帖子标题" autocomplete="off"/>
            </div>
        </div>
        <div class="topic-content-edit">
            <textarea name="content"
                      @if ($errors->has('content'))
                      class="error"
                @endif
            >{{ old('content','') }}</textarea>
        </div>
        <div class="topic-btns">
            <button type="submit">发表帖子</button>
        </div>
    </form>
@endsection
