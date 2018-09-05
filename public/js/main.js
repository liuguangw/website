var fadeInAnimated = "animated faster pulse",
    fadeOutAnimated = "animated faster fadeOutUp";

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

function needLogin() {
    location.href = "/user/login";
}

/**/
var mouseStartPos = {
    enabled: false,
    target: null,
    targetLeft: 0,
    targetTop: 0,
    x: 0,
    y: 0
};
window.addEventListener("mouseup", function (event) {
    if (mouseStartPos.enabled) {
        mouseStartPos.enabled = false;
    }
});
window.addEventListener("mousemove", function (event) {
    if (mouseStartPos.enabled) {
        var newLeft = event.screenX - mouseStartPos.x + mouseStartPos.targetLeft;
        var newTop = event.screenY - mouseStartPos.y + mouseStartPos.targetTop;
        var opTarget = mouseStartPos.target;
        opTarget.style.left = newLeft + "px";
        opTarget.style.top = newTop + "px";
    }
});

function bindDragEvent(dialogEl) {
    var btns = dialogEl.getElementsByClassName("dialog-border");
    var bindFunc = function (opItem, targetDialog) {
        opItem.addEventListener("mousedown", function (event) {
            mouseStartPos.enabled = true;
            mouseStartPos.target = targetDialog;
            mouseStartPos.targetLeft = parseInt(targetDialog.style.left);
            mouseStartPos.targetTop = parseInt(targetDialog.style.top);
            mouseStartPos.x = event.screenX;
            mouseStartPos.y = event.screenY;
            event.stopPropagation();
        });
    };
    for (var i = 0; i < btns.length; i++) {
        bindFunc(btns[i], dialogEl);
    }
    bindFunc(dialogEl.getElementsByTagName("h3").item(0), dialogEl);
}
