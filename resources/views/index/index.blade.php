@extends('layouts.main')
@section('title', 'forum首页')
@section('content')
    <div class="forum-group-list">
        @foreach ($forumGroups as $groupInfo)
            @component('components.forum_group',['groupInfo'=>$groupInfo])
            @endcomponent
        @endforeach
    </div>
@endsection
