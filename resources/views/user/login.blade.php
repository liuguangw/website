@extends('layouts.login')
@section('title', '登录/注册')
@section('content')
    <div class="main-container">
        <div class="form-warp">
            <!-- start login form -->
            <div id="login" class="login-form" @if ($defaultAction != 'login')
            style="display: none"
                @endif>
                @include('user._login_form')
            </div>
            <!-- end login form -->
            <!-- start reg form -->
            <div id="register" class="login-form" @if ($defaultAction != 'register')
            style="display: none"
                @endif>
                @include('user._register_form')
            </div>
            <!-- end reg form -->
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

        (function () {
            /*captcha*/
            var itemNavs = document.getElementsByClassName("captcha-nav-image");

            function reloadCaptcha(captchaIndex) {
                /*删除旧验证码节点*/
                var parentEl = itemNavs.item(captchaIndex);
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
                });
                imgElement.addEventListener("click", function () {
                    reloadCaptcha(captchaIndex);
                });
                imgElement.src = "{{ route('captcha') }}?r=" + Math.random();
            }

            for (var itemIndex = 0; itemIndex < itemNavs.length; itemIndex++) {
                (function (elIndex) {
                    itemNavs.item(elIndex).getElementsByTagName("img").item(0).addEventListener("click", function () {
                        reloadCaptcha(elIndex);
                    });
                })(itemIndex);
            }

            /**/
            var fadeInAnimated = "animated faster pulse",
                fadeOutAnimated = "animated faster bounceOutLeft";
            var formItems = [document.getElementById("login"), document.getElementById("register")];
            var btns = [document.getElementById("showLoginFormBtn"), document.getElementById("showRegFormBtn")];
            var urls = ["{{ action('UserController@login') }}", "{{ action('UserController@register') }}"];
            var formInputs = document.getElementsByClassName("inputbox");
            /*记录原始序号*/
                @if ($defaultAction == 'login')
            var originIndex = 0;
                @else
            var originIndex = 1;

            @endif

            function showPage(pageIndex) {
                var showForm = formItems[pageIndex],
                    hideForm = formItems[1 - pageIndex];
                /*hide*/
                hideForm.className = "login-form " + fadeOutAnimated;
                /*刷新验证码*/
                reloadCaptcha(pageIndex);
                setTimeout(function () {
                    hideForm.style.display = "none";
                    hideForm.className = "login-form";
                    /*清除错误提示框*/
                    var i, tmpItem;
                    for (i = 0; i < formInputs.length; i++) {
                        tmpItem = formInputs.item(i);
                        if (tmpItem.className != "inputbox") {
                            tmpItem.className = "inputbox";
                        }
                        /*清理内容*/
                        if (tmpItem.value != "") {
                            tmpItem.value = "";
                        }
                    }
                    var alertNavs = document.getElementsByClassName("alert");
                    for (i = alertNavs.length - 1; i >= 0; i--) {
                        alertNavs.item(i).parentNode.removeChild(alertNavs.item(i));
                    }
                    /*show*/
                    showForm.className = "login-form " + fadeInAnimated;
                    showForm.style.display = "block";
                }, 500);
            }

            for (var btnIndex in btns) {

                /*为a标签分别绑定点击事件*/
                (function (btn, targetIndex) {
                    btn.addEventListener("click", function (e) {
                        /*阻止a标签默认行为*/
                        e.preventDefault();
                        /*展示页面*/
                        showPage(targetIndex);
                        /*修改url*/
                        if ("pushState" in window.history) {
                            window.history.pushState({currentPageIndex: targetIndex}, null, urls[targetIndex]);
                        }
                    })
                })(btns[btnIndex], btnIndex);

            }
            /*处理浏览器前进后退事件*/
            window.addEventListener("popstate", function (e) {
                if (e.state != null) {
                    showPage(e.state.currentPageIndex);
                } else {
                    showPage(originIndex);
                }
            });
            /*表单错误状态清除*/
            for (var i = 0; i < formInputs.length; i++) {
                formInputs.item(i).addEventListener("focus", function () {
                    if (this.className != "inputbox") {
                        this.className = "inputbox";
                    }
                });
            }
        })();
    </script>
@endsection
