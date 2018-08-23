@extends('layouts.main')
@section('title', 'forum -'.$groupInfo->name)
@section('content')
    <div class="forum-group-list">
            @component('components.forum_group_w',['groupInfo'=>$groupInfo])
            @endcomponent
    </div>
@endsection
