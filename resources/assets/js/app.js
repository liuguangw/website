var fadeInAnimated = "animated faster pulse",
    fadeOutAnimated = "animated faster fadeOutUp";
var captchaUrl = "/captcha",
    loadingImgUrl = "/images/loading.gif";

/**
 * 显示对话框
 * @param dialogEl 对话框对象
 * @param options 设置
 * @return void
 */
function showDialog(dialogEl, options = {}) {
    if (dialogEl.style.display == "none") {
        var dialogElClass = dialogEl.className;
        dialogEl.className += (" " + fadeInAnimated);
        if ("display" in options) {
            dialogEl.style.display = options.display;
        } else {
            dialogEl.style.display = "block";
        }
        var displayCenter = false;
        if ("center" in options) {
            displayCenter = options.center;
        }
        if (displayCenter) {
            centerDialog(dialogEl);
        }
        if ("showCallback" in options) {
            options.showCallback(dialogEl);
        }
        setTimeout(function () {
            dialogEl.className = dialogElClass;
            if ("callback" in options) {
                options.callback(dialogEl);
            }
        }, 500);
    }
}

/**
 * 隐藏对话框
 * @param dialogEl 对话框对象
 * @param options 设置
 * @return void
 */
function hideDialog(dialogEl, options = {}) {
    if (dialogEl.style.display != "none") {
        var dialogElClass = dialogEl.className;
        dialogEl.className += (" " + fadeOutAnimated);
        setTimeout(function () {
            dialogEl.style.display = "none";
            dialogEl.className = dialogElClass;
            if ("callback" in options) {
                options.callback(dialogEl);
            }
        }, 500);
    }
}

/**
 * 将对话框居中
 * @param dialogEl 对话框对象
 * @return void
 */
function centerDialog(dialogEl) {
    dialogEl.style.left = (window.innerWidth - dialogEl.offsetWidth) / 2 + "px";
    dialogEl.style.top = (window.innerHeight - dialogEl.offsetHeight) / 2 + "px";
}

/**
 * 登录跳转
 * @return void
 */
function needLogin() {
    location.href = "/user/login";
}

/**
 * 加载验证码
 * @param parentEl
 */
function loadCaptcha(parentEl) {
    var captchaInited = false;
    if ("captcha_init" in parentEl.dataset) {
        captchaInited = (parentEl.dataset.captcha_init == 1);
    }
    if(captchaInited) {
        //移除旧的验证码图片
        var oldImgElement = parentEl.getElementsByTagName("img").item(0);
        parentEl.removeChild(oldImgElement);
        /*显示加载中*/
        var loadingEl = document.createElement("img");
        parentEl.appendChild(loadingEl);
        loadingEl.alt = "加载中";
        loadingEl.title = "加载中";
        loadingEl.src = loadingImgUrl;
    }
    /*加载新验证码*/
    var imgElement = document.createElement("img");
    imgElement.alt = "图形验证码";
    imgElement.title = "点击刷新";
    imgElement.addEventListener("load", function () {
        parentEl.removeChild(parentEl.getElementsByTagName("img").item(0));
        parentEl.appendChild(this);
        parentEl.dataset.captcha_init = 1;
    });
    imgElement.addEventListener("click", function () {
        loadCaptcha(this.parentNode);
    });
    imgElement.src = captchaUrl + "?r=" + Math.random();
}
