@extends('layouts.main')
@section('title', 'forum -'.$forum->name)
@section('content')
    @php
        $loginUrl = route('login',[ 'back' => 1 ]);
        $registerUrl = route('register',[ 'back' => 1 ]);
    @endphp
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
    @include('topic._topic_pagination')
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
                        @unless(empty($topicType))
                            <span>[</span>
                            <a class="topic-type-link"
                               @unless($topicType->color=='')
                               style="color:{{ $topicType->color }};"
                               @endunless
                               href="{{ $forum->link(['type'=>$topicType->id]) }}">{{ $topicType->name }}</a>
                            <span>]</span>
                        @endunless
                        <h1>{{ $topic->title }}</h1>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="sep1"></td>
                <td class="sep2"></td>
            </tr>
            {{-- 第1页才显示帖子 --}}
            @if($page==1)
                <tr>
                    <td class="left-side">
                        @include('topic._topic_post_author',['author'=>$topicAuthor])
                    </td>
                    <td>
                        <div class="post-detail">
                            {{-- 帖子内容 --}}
                            @include('topic._topic_content')
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="left-side"></td>
                    <td class="action-nav-warp">
                        <div class="action-nav">
                            @include('topic._topic_actions',[ 'postItem' => $topic ])
                        </div>
                    </td>
                </tr>
            @endif
            {{-- 显示回复列表,如果存在 --}}
            @if(!$replies->isEmpty())
                @foreach($replies as $replyInfo)
                    <tr>
                        <td class="sep1"></td>
                        <td class="sep2"></td>
                    </tr>
                    <tr>
                        <td class="left-side">
                            @include('topic._topic_post_author',['author'=>$replyInfo->author])
                        </td>
                        <td>
                            <div class="post-detail">
                                @include('topic._topic_reply_content')
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-side"></td>
                        <td class="action-nav-warp">
                            <div class="action-nav">
                                @include('topic._topic_actions',[ 'postItem' => $replyInfo ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
    @include('topic._topic_pagination')
    @if(!$topic->t_locked)
        {{--  帖子底部回帖区域 --}}
        @include('topic._topic_reply_box')
        {{-- 回帖弹框 --}}
        @include('topic._topic_reply_dialog')
    @endif
    @if($errors->any())
        {{-- 错误提示 --}}
        @component('components.alert_dialog',['alertId'=>'topic_error_dialog','alertClass'=>'alert-danger'])
        @endcomponent
    @endif
    @if(\Illuminate\Support\Facades\Session::has('success'))
        {{-- 操作成功提示 --}}
        @component('components.alert_dialog',['alertId'=>'topic_success_dialog','alertClass'=>'alert-success','success'=>\Illuminate\Support\Facades\Session::get('success')])
        @endcomponent
    @endif
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript">
        var dialogEl = document.getElementsByClassName("reply-dialog").item(0);
        bindDragEvent(dialogEl);

        function showReplyDialog(floor_id) {
            var formEl = dialogEl.getElementsByTagName("form").item(0);
            formEl.to_floor_id.value = floor_id;
            formEl.content.value = "";
            showDialog(dialogEl, {
                display: "table",
                center: true
            });
        }

        /**
         * 点击关闭按钮时用于关闭弹框
         * @param closeBtn 关闭按钮
         * @return void
         */
        function closeDialog(closeBtn) {
            var oDialog = closeBtn;
            while (oDialog.tagName.toLowerCase() != "table") {
                oDialog = oDialog.parentNode;
            }
            hideDialog(oDialog);
        }

        function captchaBindFn(captchaNav) {
            if (captchaNav == null) {
                return;
            }
            var captchaWarp = captchaNav.getElementsByClassName("reply-captcha-warp").item(0);
            /*鼠标离开区域时,验证码隐藏*/
            captchaNav.addEventListener("mouseleave", function () {
                if (captchaWarp.style.display != "none") {
                    captchaWarp.style.display = "none";
                }
            });
            var captchaParent = captchaWarp.getElementsByTagName("div").item(1);
            var focusFn = function () {
                if (captchaWarp.style.display == "none") {
                    if (!("captcha_init" in captchaParent.dataset)) {
                        loadCaptcha(captchaParent);
                    }
                    captchaWarp.style.display = "block";
                }
            };
            captchaNav.getElementsByTagName("input").item(0).addEventListener("focus", focusFn);
            captchaNav.getElementsByTagName("input").item(0).addEventListener("mousedown", focusFn);
            captchaNav.getElementsByTagName("a").item(0).addEventListener("click", function () {
                loadCaptcha(captchaParent);
            });
        }

        /*  回复框验证码事件绑定 */
        if (dialogEl != null) {
            captchaBindFn(dialogEl.getElementsByClassName("reply-captcha").item(0));
        }
        captchaBindFn(document.getElementsByClassName("box-captcha").item(0));
        /* 错误提示 */
        @if($errors->any())
        (function () {
            var errorDialogEl = document.getElementById("topic_error_dialog");
            centerDialog(errorDialogEl);
            setTimeout(function () {
                errorDialogEl.className = "alert-dialog " + fadeOutAnimated;
                var parentEl = errorDialogEl.parentNode;
                setTimeout(function () {
                    parentEl.removeChild(errorDialogEl);
                }, 500);
            }, 1900);
        })();
        @endif
        /*  操作成功提示 */
        @if(\Illuminate\Support\Facades\Session::has('success'))
        (function () {
            var opDialogEl = document.getElementById("topic_success_dialog");
            centerDialog(opDialogEl);
            setTimeout(function () {
                opDialogEl.className = "alert-dialog " + fadeOutAnimated;
                var parentEl = opDialogEl.parentNode;
                setTimeout(function () {
                    parentEl.removeChild(opDialogEl);
                }, 500);
            }, 900);
        })();
        @endif
    </script>
@endpush
