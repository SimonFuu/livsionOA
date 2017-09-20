/**
 * Created by simon on 17/07/2017.
 */

var resizeIFrame = function () {
    var contentWapper = $('.parent-window-content-wapper');
    var height = contentWapper.height();
    contentWapper.children('.content').children('iframe').css('height', height - 5);
    $('.shadow-on-iframe').css('height', height - 5);
    $(window).resize(function () {
        height = contentWapper.height();
        contentWapper.children('.content').children('iframe').css('height', height - 5);
        $('.shadow-on-iframe').css('height', height - 5);
    });
};

var showDropDownMenus = function () {
    var menu = $('.mouse-dropdown');
    menu.on('mouseover', function () {
        $(this).addClass('open')
    });
    menu.on('mouseout', function () {
        $(this).removeClass('open')
    });
};

var sidebarClick = function () {
    $('.sidebar-menu-item').on('click', function () {
        $(this).siblings('li').each(function (index, element) {
            $(element).removeClass('active');
            if ($(element).hasClass('treeview')) {
                $(element).children('.treeview-menu').css('display', 'none');
            }
        });
        if (!$(this).hasClass('active')) {
            $(this).addClass('active')
        }
    });

    $('.treeview-menu > li').on('click', function () {
        $(this).siblings('li').each(function (index, element) {
            $(element).removeClass('active');
        });
        if (!$(this).hasClass('active')) {
            $(this).addClass('active')
        }
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

var chunk = function (array, size) {
    var temp = [];
    for (var i = 0; i< array.length; i = i + size) {
        var tempArr = array;
        temp.push(tempArr.slice(i, i + size))
    }
    return temp;
};

var setActionIcons = function () {
    var icons = [];
    var maxIconsCountInLine = 0;
    var maxIconsDisplayLines = 6;
    var currentPage = 0;
    var lastPage = 0;
    var modalWidth = 0;
    if (typeof actionIcons !== 'undefined') {
        icons = JSON.parse(actionIcons);
        $('#setActionIconModal').on('shown.bs.modal', function () {
            $('.set-actions-icon-name').val('');
            modalWidth = $('.set-actions-icons-list-modal').width();
            maxIconsCountInLine = Math.floor(modalWidth / 38);
            pageIconsCount = maxIconsDisplayLines * (maxIconsCountInLine === 0 ? 8 : maxIconsCountInLine);
            actionIcons = chunk(icons, pageIconsCount);
            lastPage = actionIcons.length;
            appendActionIconsListHtml(actionIcons[currentPage], maxIconsCountInLine, maxIconsDisplayLines, currentPage, lastPage);
        });

        $('.set-actions-previous').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var previousPage = $(this).data('previous');
                appendActionIconsListHtml(actionIcons[previousPage], maxIconsCountInLine, maxIconsDisplayLines, previousPage, lastPage);
            }
        });

        $('.set-actions-next').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                var nextPage = $(this).data('next');
                appendActionIconsListHtml(actionIcons[nextPage], maxIconsCountInLine, maxIconsDisplayLines, nextPage, lastPage);
            }
        });

        $('.set-actions-icon-name').on('input propertychange', function () {
            var words = $(this).val();
            var resultIcons = searchIconsArray(words, icons);
            if (resultIcons.length > 0) {
                actionIcons = chunk(resultIcons, pageIconsCount);
                lastPage = actionIcons.length;
                appendActionIconsListHtml(actionIcons[currentPage], maxIconsCountInLine, maxIconsDisplayLines, currentPage, lastPage);
            } else {
                appendActionIconsListHtml([], maxIconsCountInLine, maxIconsDisplayLines, -1, 0);
            }
        });
    }
};

var appendActionIconsListHtml = function (icons, iconsCountInLine, maxIconsDisplayLines, currentPage, lastPage) {
    var html = '<tr>';
    var maxDisplayIcons = maxIconsDisplayLines * iconsCountInLine;
    var maxIconsCountInLine = iconsCountInLine === 0 ? 8 : iconsCountInLine;
    var displayCount = icons.length > maxDisplayIcons ? maxDisplayIcons : icons.length;
    var lastIconIndex = displayCount - 1;
    var selectedIcon = $('.set-action-icon-value').val();
    for (var i = 0; i < displayCount; i++) {
        if (selectedIcon === icons[i]) {
            html += '<td><button class="btn btn-warning set-actions-icon-button" data-icon="' + icons[i] + '" onclick="selectActionIcon($(this));">';
        } else {
            html += '<td><button class="btn btn-default set-actions-icon-button" data-icon="' + icons[i] + '" onclick="selectActionIcon($(this));">';
        }
        html += '<i class="fa ' + icons[i] + '" aria-hidden="true"></i></button></td>';
        if (((i+1) % maxIconsCountInLine === 0) || i === lastIconIndex) {
            html += '</tr>';
            if (i !== lastIconIndex) {
                html += '<tr>';
            }
        }
    }
    var addOn = maxIconsCountInLine - (i % maxIconsCountInLine);
    if (addOn !== 0 && (addOn !== maxIconsCountInLine || i === 0)) {
        if (i !== 0) {
            html = html.substring(0, html.length - 5);
        }
        for (var j = 0; j < addOn; j++) {
            html += '<td></td>';
        }
        html += '</tr>';
    }
    $('.set-actions-icons-list > tbody').html(html);
    var paginate = $('.set-actions-page-info');
    paginate.attr('colspan', maxIconsCountInLine - 2);
    $('.set-actions-icon-label').parent('td').attr('colspan', maxIconsCountInLine);
    var previousBtn = $('.set-actions-previous');
    var nextBtn = $('.set-actions-next');
    if (currentPage <= 0) {
        if (!previousBtn.hasClass('disabled')) {
            previousBtn.addClass('disabled')
        }
    } else {
        if (previousBtn.hasClass('disabled')) {
            previousBtn.removeClass('disabled')
        }
    }
    if (currentPage >= (lastPage - 1)) {
        if (!nextBtn.hasClass('disabled')) {
            nextBtn.addClass('disabled')
        }
    } else {
        if (nextBtn.hasClass('disabled')) {
            nextBtn.removeClass('disabled')
        }
    }
    paginate.html((currentPage + 1) + ' / ' + lastPage);
    previousBtn.data('previous', currentPage - 1);
    nextBtn.data('next', currentPage + 1);
};

var selectActionIcon = function (e) {
    $('.set-action-icon').html('<i class="fa ' + e.data('icon') + '" aria-hidden="true"></i>');
    $('.set-action-icon-value').val(e.data('icon'));
    if (!e.hasClass('btn-warning')) {
        e.removeClass('btn-default');
        e.parents('tbody').find('.btn').each(function (index, element) {
            if ($(element).hasClass('btn-warning')) {
                $(element).removeClass('btn-warning');
                $(element).addClass('btn-default');
            }
        });
        e.addClass('btn-warning');
    }
};

var searchIconsArray =  function(str, container) {
    var nPos;
    var vResult = [];

    for(var i in container){
        var sTxt=container[i]||'';
        nPos=sTxt.indexOf(str);
        if(nPos>=0){
            vResult[vResult.length] = sTxt;
        }
    }
    return vResult;
};

var uploadFiles = function () {
    var avatarField = $('#avatar');
    if (avatarField.length > 0) {
        var avatarImg = $(".kv-avatar").data('avatar');
        avatarField.fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="'+avatarImg+'" alt="Your Avatar" width="160"><h6 class="text-muted">Click to select</h6><h6>(Select file < 1500k)</h6>',
            layoutTemplates: {main2: '{preview} {remove} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    }
};

var departmentsListSelect = function () {
    var treeA = $('.tree-menu > li > a');
    if (typeof (currentDID) !== 'undefined') {
        treeA.each(function (index, element) {
            console.log($(element).data('d-id'), parseInt(currentDID));
            if ($(element).data('d-id') === parseInt(currentDID)) {
                $(element).parent('li').addClass('active');
            }
        })
    }
    treeA.on('click', function () {
        $('.tree-menu > li').removeClass('active');
        $(this).parent('li').addClass('active');
        if ($(this).parents('.departments-tree-menu').length > 0) {
            getDepartmentInfo($(this));
        } else if($(this).parents('.contacts-departments').length > 0) {
            getDepartmentUsers($(this));
        } else {
            var selectParentDepartmentModal = $('#selectParentDepartmentModal');
            if(selectParentDepartmentModal.length > 0) {
                selectParentDepartmentModal.modal('hide');
                $('input[name="parentDepartment"]').val($(this).data('d-id'));
                $('#parentDepartmentName').val($(this).children('.department-name').html());
                return true;
            }
            var selectUserDepartmentModal = $('#selectUserDepartmentModal');
            if (selectUserDepartmentModal.length > 0) {
                selectUserDepartmentModal.modal('hide');
                $('input[name="departmentId"]').val($(this).data('d-id'));
                $('#departmentName').val($(this).children('.department-name').html());
                return true;
            }
        }
    });
};

var getDepartmentInfo = function (element) {
    $.ajax({
        cache: false,
        type: 'GET',
        url: '/system/departments/get',
        async: false,
        data: {'id': element.data('d-id')},
        success: function (data) {
            if (data.status) {
                $('#departmentName').val(data.data.departmentName);
                $('#parentDepartmentName').val(data.data.parentName);
                $('input[name="parentDepartment"]').val(data.data.parentDepartment);
                $('#weight').val(data.data.weight);
                $('#description').val(data.data.description);
                $('input[name="id"]').val(data.data.id);
                $('.selectParentDepartmentButton').prop('disabled', false)
            } else {
                var html = '<div class="alert alert-danger alert-dismissable">';
                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                html += data.message + '</div>';
                $('.alert-area').html(html)
            }
        },
        error: function (request) {
            var message = '请稍后再试！';
            if (request.status === 404) {
                message = '请求地址不存在，请联系管理员确认！'
            } else if(request.status >= 500) {
                message = '请求异常，请稍后再试！'
            }
            var html = '<div class="alert alert-danger alert-dismissable">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += message + '</div>';
            $('.alert-area').html(html);
        }
    });
};

var getDepartmentUsers = function (element) {
    $('input[name="name"]').val('');
    $.ajax({
        cache: false,
        type: 'GET',
        url: '/contacts/index',
        async: false,
        data: {'did': element.data('d-id')},
        success: function (data) {
            if (data.status) {
                var contactsListBody = $('.contacts-list-body');
                var contactsPagination= $('.contacts-list-pagination');
                contactsListBody.html('');
                contactsPagination.html('');
                var usersItem = data.data.users.data;
                var usersItemCount = usersItem.length;
                if (usersItemCount > 0) {
                    var usersItemHtml = '<tr>';
                    for(var i = 0; i < usersItemCount; i++) {
                        usersItemHtml += '<td>' + usersItem[i].username + '</td>';
                        usersItemHtml += '<td>' + usersItem[i]['name'] + '</td>';
                        usersItemHtml += '<td>' + usersItem[i]['departmentName'] + '</td>';
                        usersItemHtml += '<td>' + usersItem[i]['positionName'] + '</td>';
                        usersItemHtml += '<td>' + usersItem[i]['telephone'] + '</td>';
                        usersItemHtml += '<td>' + (usersItem[i]['officeTel'] ? usersItem[i]['officeTel'] : '空') + '</td>';
                        usersItemHtml += '<td>' + (usersItem[i]['email'] ? usersItem[i]['email'] : '空') + '</td></tr>';
                    }
                    contactsListBody.html(usersItemHtml);
                }
                contactsPagination.html(data.data.pagination);
            } else {
                var html = '<div class="alert alert-danger alert-dismissable">';
                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                html += data.message + '</div>';
                $('.alert-area').html(html)
            }
        },
        error: function (request) {
            var message = '请稍后再试！';
            if (request.status === 404) {
                message = '请求地址不存在，请联系管理员确认！'
            } else if(request.status >= 500) {
                message = '请求异常，请稍后再试！'
            }
            var html = '<div class="alert alert-danger alert-dismissable">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += message + '</div>';
            $('.alert-area').html(html);
        }
    });
};

var deleteDepartment = function () {
    $('.delete-department').on('click', function () {
        var li = $('.departments-tree-menu').find('li[class="active"]');
        if (li.length === 0) {
            var html = '<div class="alert alert-danger alert-dismissable">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += '请选择要删除的部门！</div>';
            $('.alert-area').html(html);
            return false;
        } else {
            if (confirm('该操作将一同删除该部门的下级部门，请确认！')) {
                var id = '';
                li.each(function (index, element) {
                    id = '?id=' + $(element).children('a').data('d-id');
                });
                $(this).attr('href', $(this).attr('href') + id);
                return true;
            } else {
                return false;
            }
        }
    });
};

var selectPositions = function () {
    $('.positions-list-body > tr').on('click', function () {
        $('.positions-list-body').children('tr').removeClass('active');
        $.ajax({
            cache: false,
            type: 'GET',
            url: '/system/positions/get',
            async: false,
            data: {'id': $(this).data('p-id')},
            success: function (data) {
                if (data.status) {
                    $('.ed-positionName').val(data.data.positionName);
                    $('.ed-weight').val(data.data.weight);
                    $('.ed-status').val(data.data.status);
                    $('.ed-description').val(data.data.description);
                    $('.ed-id').val(data.data.id);
                } else {
                    var html = '<div class="alert alert-danger alert-dismissable">';
                    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                    html += data.message + '</div>';
                    $('.alert-area').html(html)
                }
            },
            error: function (request) {
                var message = '请稍后再试！';
                if (request.status === 404) {
                    message = '请求地址不存在，请联系管理员确认！'
                } else if(request.status >= 500) {
                    message = '请求异常，请稍后再试！'
                }
                var html = '<div class="alert alert-danger alert-dismissable">';
                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                html += message + '</div>';
                $('.alert-area').html(html);
            }
        });
        $(this).addClass('active');
    });
};

var deletePosition = function () {
    $('.delete-position').on('click', function () {
        var tr = $('.positions-list-body').find('tr[class="active"]');
        if (tr.length === 0) {
            var html = '<div class="alert alert-danger alert-dismissable">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += '请选择要删除的职位！</div>';
            $('.alert-area').html(html);
            return false;
        } else {
            if (confirm('您是否要删除该职位？')) {
                var id = '';
                tr.each(function (index, element) {
                    id = '?id=' + $(element).data('p-id');
                });
                $(this).attr('href', $(this).attr('href') + id);
                return true;
            } else {
                return false;
            }
        }
    });
};

var isAdminChange = function () {
    var isAdmin = $('input[name="isAdmin"]:checked');
    if (isAdmin.length > 0) {
        if (isAdmin.val() === '1') {
            $('.admin-roles').removeClass('hidden');
            $('input[name="roles[]"]').prop('disabled', false)
        } else {
            $('.admin-roles').addClass('hidden');
            $('input[name="roles[]"]').prop('disabled', true)
        }
    }
    $('input[name="isAdmin"]').on('change', function () {
        if ($(this).val() === '1') {
            $('.admin-roles').removeClass('hidden');
            $('input[name="roles[]"]').prop('disabled', false)
        } else {
            $('.admin-roles').addClass('hidden');
            $('input[name="roles[]"]').prop('disabled', true)
        }
    });
};

$(document).ready(function () {
    resizeIFrame();
    showDropDownMenus();
    sidebarClick();
    setActionIcons();
    roleActionsCheckboxRelate();
    uploadFiles();
    departmentsListSelect();
    deleteDepartment();
    selectPositions();
    deletePosition();
    isAdminChange();
});