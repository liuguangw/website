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
