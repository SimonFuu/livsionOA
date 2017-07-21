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

var roleActionsCheckboxRelate = function () {
    $('.parentRoleAction').on('click', function () {
        if ($(this).is(':checked')) {
            // 勾选，将所有子菜单勾选
            $(this).parents('table').find('.childRoleAction').each(function (index, element) {
                $(element).prop('checked', true);
            });
        } else {
            // 移除勾选，移除所有子菜单的勾选状态
            $(this).parents('table').find('.childRoleAction').each(function (index, element) {
                $(element).prop('checked', false);
            });
        }
    });

    $('.childRoleAction').on('click', function () {
        if ($(this).is(':checked')) {
            // 子菜单勾选，则触发父级菜单勾选
            $(this).parents('table').find('.parentRoleAction').prop('checked', true);
        } else {
            // 子菜单移除勾选，判断当前子菜单勾选数量，如果为0，则移除父级菜单的勾选
            var table = $(this).parents('table');
            if (table.find('.childRoleAction:checked').length === 0) {
                table.find('.parentRoleAction').prop('checked', false);
            }
        }
    });
};
$(document).ready(function () {
    resizeIFrame();
    roleActionsCheckboxRelate();
});