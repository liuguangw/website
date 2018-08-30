function bindDragEvent(dialogEl) {
    var btns=dialogEl.getElementsByClassName("dialog-border");
    var bindFunc=function(opItem){
        var offsetx=0,offsety=0;
        opItem.addEventListener("mouseenter",function (event) {
            console.log(event);
        });
        opItem.addEventListener("mouseleave",function (event) {
            console.log(event);
        });
        /*opItem.addEventListener("mousemove",function (event) {
            console.log(event);
        });*/
    };
    for(var i=0;i<btns.length;i++){
        bindFunc(btns[i]);
    }
    bindFunc(dialogEl.getElementsByTagName("h3").item(0));
}
