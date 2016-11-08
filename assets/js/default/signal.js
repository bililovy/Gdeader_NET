var headerNavcontentWidth=30+$('.header .inner_main .searbtnbox').width()+$('.header .navigator').width();
headerResponse(headerNavcontentWidth);
searchBarBox();
footerTextAnimate();
window.onresize=function (){
    headerResponse(headerNavcontentWidth);
    searchBarBox();
}