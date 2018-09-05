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
    <div class="topic-reply-btns clearfix">
        <div class="btns">
            <a class="btn-post" href="{{ action('TopicController@create',['id'=>$forum->id]) }}">发帖</a>
            @if(!$topic->t_locked)
                <a class="btn-reply" href="javascript:void(0);"
                   @auth
                   onclick="showReplyDialog(0)"
                   @else
                   onclick="needLogin()"
                    @endauth
                >回复</a>
            @endif
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
                            @component('components.topic_content',['topic'=>$topic])
                            @endcomponent
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="left-side"></td>
                    <td class="action-nav-warp">
                        <div class="action-nav">
                            @if(!$topic->t_locked)
                                <span class="action-item">
                                     <a class="action-reply" href="javascript:void(0);"
                                        @auth
                                        onclick="showReplyDialog(0)"
                                        @else
                                        onclick="needLogin()"
                                         @endauth
                                     >回复</a>
                                </span>
                            @endif
                            <span class="action-item">
                                 <a class="action-like" href="javascript:void(0);"
                                    @auth
                                    @if(empty($topic->likeLog))
                                    onclick="likePost({{ $topic->id }},true)"
                                    @elseif($topic->likeLog->is_like)
                                    onclick="cancelLikePost({{ $topic->id }})"
                                    @else
                                    onclick="likePost({{ $topic->id }},false)"
                                    @endif
                                    @else
                                    onclick="needLogin()"
                                     @endauth
                                 >支持 0</a>
                            </span>
                            <span class="action-item">
                                 <a class="action-notlike" href="javascript:void(0);"
                                    @auth
                                    @if(empty($topic->likeLog))
                                    onclick="unlikePost({{ $topic->id }},true)"
                                    @elseif(!$topic->likeLog->is_like)
                                    onclick="cancelUnlikePost({{ $topic->id }})"
                                    @else
                                    onclick="unlikePost({{ $topic->id }},false)"
                                    @endif
                                    @else
                                    onclick="needLogin()"
                                     @endauth
                                 >反对 0</a>
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
                                @component('components.reply_content',['replyInfo'=>$replyInfo])
                                @endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="left-side"></td>
                        <td class="action-nav-warp">
                            <div class="action-nav">
                                @if(!$topic->t_locked)
                                    <span class="action-item">
                                        <a class="action-reply" href="javascript:void(0);"
                                           @auth
                                           onclick="showReplyDialog({{ $replyInfo->floor_id }})"
                                           @else
                                           onclick="needLogin()"
                                            @endauth
                                        >回复</a>
                                    </span>
                                @endif
                                <span class="action-item">
                                     <a class="action-like" href="javascript:void(0);"
                                        @auth
                                        @if(empty($replyInfo->likeLog))
                                        onclick="likePost({{ $replyInfo->id }},true)"
                                        @elseif($replyInfo->likeLog->is_like)
                                        onclick="cancelLikePost({{ $replyInfo->id }})"
                                        @else
                                        onclick="likePost({{ $replyInfo->id }},false)"
                                        @endif
                                        @else
                                        onclick="needLogin()"
                                         @endauth
                                     >支持 0</a>
                                </span>
                                <span class="action-item">
                                     <a class="action-notlike" href="javascript:void(0);"
                                        @auth
                                        @if(empty($replyInfo->likeLog))
                                        onclick="unlikePost({{ $replyInfo->id }},true)"
                                        @elseif(!$replyInfo->likeLog->is_like)
                                        onclick="cancelUnlikePost({{ $replyInfo->id }})"
                                        @else
                                        onclick="unlikePost({{ $replyInfo->id }},false)"
                                        @endif
                                        @else
                                        onclick="needLogin()"
                                         @endauth
                                     >反对 0</a>
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
            @if(!$topic->t_locked)
                <a class="btn-reply" href="javascript:void(0);"
                   @auth
                   onclick="showReplyDialog(0)"
                   @else
                   onclick="needLogin()"
                    @endauth
                >回复</a>
            @endif
        </div>
        <!--分页-->
        @component('components.pagination',['pagination'=>$pagination])
        @endcomponent
    </div>
    @if(!$topic->t_locked)
        @component('components.dialog',['extClass'=>' reply-dialog'])
            <form method="post" action="{{ action('ReplyController@store') }}">
                @csrf
                <div class="dialog-warp">
                    <a class="dialog-close-icon" href="javascript:void(0)" onclick="closeDialog(this);"></a>
                    <h3>参与/回复主题</h3>
                    <input type="hidden" name="to_floor_id" value="0"/>
                    <input type="hidden" name="topic_id" value="{{ $topic->id }}"/>
                    <div class="reply-edit">
                        <textarea name="content"></textarea>
                    </div>
                    <div class="reply-captcha">
                        <span>验证码</span>
                        <input type="text" name="captcha_code" value="" placeholder="输入验证码" autocomplete="off"/>
                        <a href="javascript:void(0)">换一个</a>
                        <div class="reply-captcha-warp" style="display: none;">
                            <div>请输入下图中的字符</div>
                            <div><img src="{{ asset('images/loading.gif') }}" alt="验证码"/></div>
                        </div>
                    </div>
                </div>
                <div class="dialog-footer">
                    <a href="">本版积分规则</a>
                    <button class="dialog-btn" type="submit">参与/回复主题</button>
                </div>
            </form>
        @endcomponent
    @endif
    @if($errors->any())
        @component('components.alert_dialog',['alertId'=>'topic_error_dialog','alertClass'=>'alert-danger','errors'=>$errors])
        @endcomponent
    @endif
    @if(\Illuminate\Support\Facades\Session::has('reply_success'))
        @component('components.alert_dialog',['alertId'=>'topic_success_dialog','alertClass'=>'alert-success','errors'=>null])
            回复成功
        @endcomponent
    @endif
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
    <script type="text/javascript">
        var dialogEl = document.getElementsByClassName("reply-dialog").item(0);
        bindDragEvent(dialogEl);

        function showReplyDialog(floor_id) {
            var formEl = dialogEl.getElementsByTagName("form").item(0);
            formEl.to_floor_id.value = floor_id;
            formEl.content.value = "";
            showDialog(dialogEl,{
                display:"table",
                center:true
            });
        }

        function closeDialog(closeBtn) {
            var oDialog = closeBtn;
            while (oDialog.tagName.toLowerCase() != "table") {
                oDialog = oDialog.parentNode;
            }
            hideDialog(oDialog);
        }

        var captchaNav = document.getElementsByClassName("reply-captcha").item(0);
        var captchaWarp = captchaNav.getElementsByClassName("reply-captcha-warp").item(0);
        var captchaInited = false;

        function reloadCaptcha() {
            /*删除旧验证码节点*/
            var parentEl = captchaWarp.getElementsByTagName("div").item(1);
            var oldImgElement = parentEl.getElementsByTagName("img").item(0);
            parentEl.removeChild(oldImgElement);
            /*显示加载中*/
            var loadingEl = document.createElement("img");
            parentEl.appendChild(loadingEl);
            loadingEl.alt = "加载中";
            loadingEl.title = "加载中";
            loadingEl.src = "{{ asset('images/loading.gif') }}";
            /*加载新验证码*/
            var imgElement = document.createElement("img");
            imgElement.alt = "图形验证码";
            imgElement.title = "点击刷新";
            imgElement.addEventListener("load", function () {
                parentEl.removeChild(parentEl.getElementsByTagName("img").item(0));
                parentEl.appendChild(imgElement);
                captchaInited = true;
            });
            imgElement.addEventListener("click", reloadCaptcha);
            imgElement.src = "{{ route('captcha') }}?r=" + Math.random();
        }

        captchaNav.addEventListener("mouseleave", function () {
            if (captchaWarp.style.display != "none") {
                captchaWarp.style.display = "none";
            }
        });
        var focusFn = function () {
            if (captchaWarp.style.display == "none") {
                if (!captchaInited) {
                    reloadCaptcha();
                }
                captchaWarp.style.display = "block";
            }
        };
        captchaNav.getElementsByTagName("input").item(0).addEventListener("focus", focusFn);
        captchaNav.getElementsByTagName("input").item(0).addEventListener("mousedown", focusFn);
        captchaNav.getElementsByTagName("a").item(0).addEventListener("click", function () {
            reloadCaptcha();
        });
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

            @if(\Illuminate\Support\Facades\Session::has('reply_success'))
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
@endsection
