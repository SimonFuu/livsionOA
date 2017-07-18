/**
 * Created by simon on 17/07/2017.
 */

var resizeIFrame = function () {
    var contentWapper = $('.parent-window-content-wapper');
    var height = contentWapper.height();
    contentWapper.children('.content').children('iframe').css('height', height - 35);
    $(window).resize(function () {
        height = contentWapper.height();
        contentWapper.children('.content').children('iframe').css('height', height - 35);
    });
};
$(document).ready(function () {
    resizeIFrame();
});