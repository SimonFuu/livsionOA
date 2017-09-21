@extends('layouts.layout')
@section('body')
    <section class="content">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <div class="index-container">
                    <div class="row">
                        <section class="col-md-7 connectedSortable ui-sortable">
                            {{--新闻与通知公告--}}
                            <div class="index-page-display-part">
                                <div class="nav-tabs-custom news-and-announcement">
                                    <ul id="news-tab" class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#news-list" class="tabs-button" id="news-list-tab" role="tab" data-toggle="tab" aria-controls="news-list" aria-expanded="true">
                                                新闻
                                                <span class="label label-danger">1</span>
                                            </a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#announcements-list" class="tabs-button" role="tab" id="announcements-list-tab" data-toggle="tab" aria-controls="announcements-list" aria-expanded="false">
                                                通知公告
                                                <span class="label label-danger">1</span>
                                            </a>
                                        </li>

                                        <li class="pull-right index-page-read-more-and-display">
                                            <a class="button" data-toggle="collapse" data-parent=".news-and-announcement" href=".newsAndAnnouncementsContent" aria-expanded="true" aria-controls="newsAndAnnouncementsContent">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="pull-right index-page-read-more-and-display">
                                            <a href="#" class="">
                                                更多 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="tabContent" class="tab-content panel-collapse collapse in newsAndAnnouncementsContent">
                                        <div role="tabpanel" class="tab-pane fade active in" id="news-list" aria-labelledby="news-list-tab">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td width="5%"><span class="read-status"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">新闻1</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">新闻2</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">新闻3</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">新闻4</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">新闻5</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="announcements-list" aria-labelledby="announcements-list-tab">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">通知公告1</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">通知公告2</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">通知公告3</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">通知公告4</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">通知公告5</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--待办事项与已完结事项--}}
                            <div class="index-page-display-part">
                                <div class="nav-tabs-custom to-dos index-page-display-part">
                                    <ul id="to-dos-tab" class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#to-dos-list" class="tabs-button" id="to-dos-list-tab" role="tab" data-toggle="tab" aria-controls="to-dos-list" aria-expanded="true">待办事项</a>
                                        </li>
                                        <li role="presentation" class="">
                                            <a href="#has-done-list" class="tabs-button" role="tab" id="has-done-list-tab" data-toggle="tab" aria-controls="has-done-list" aria-expanded="false">已完结事项</a>
                                        </li>
                                        <li class="pull-right index-page-read-more-and-display">
                                            <a class="button" data-toggle="collapse" data-parent=".to-dos" href=".toDosContent" aria-expanded="true" aria-controls="toDosContent">
                                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="pull-right index-page-read-more-and-display">
                                            <a href="#" class="">
                                                更多 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="tabContent" class="tab-content panel-collapse collapse in toDosContent">
                                        <div role="tabpanel" class="tab-pane fade active in" id="to-dos-list" aria-labelledby="to-dos-list-tab">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">待办事项1</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">待办事项2</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">待办事项3</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">待办事项4</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">待办事项5</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="has-done-list" aria-labelledby="has-done-list-tab">
                                            <table class="table table-hover table-striped">
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">已完结事项1</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">已完结事项2</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">已完结事项3</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">已完结事项4</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                                <tr>
                                                    <td width="5%"><span class="read-status has-read"><i class="fa fa-circle" aria-hidden="true"></i></span></td>
                                                    <td width="80%">已完结事项5</td>
                                                    <td width="15%" class="text-right">12天前</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="col-md-5">
                            {{--轮播图新闻--}}
                            <div class="index-page-display-part">
                                <div id="carousel-news" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators index-carousel-points">
                                        <li data-target="#carousel-news" data-slide-to="0" class=""></li>
                                        <li data-target="#carousel-news" data-slide-to="1" class="active"></li>
                                        <li data-target="#carousel-news" data-slide-to="2" class=""></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item">
                                            <img data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNzc3OiM1NTUvdGV4dDpGaXJzdCBzbGlkZQpDcmVhdGVkIHdpdGggSG9sZGVyLmpzIDIuNi4wLgpMZWFybiBtb3JlIGF0IGh0dHA6Ly9ob2xkZXJqcy5jb20KKGMpIDIwMTItMjAxNSBJdmFuIE1hbG9waW5za3kgLSBodHRwOi8vaW1za3kuY28KLS0+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj48IVtDREFUQVsjaG9sZGVyXzE1ZWEzMDIyMTNmIHRleHQgeyBmaWxsOiM1NTU7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6NDVwdCB9IF1dPjwvc3R5bGU+PC9kZWZzPjxnIGlkPSJob2xkZXJfMTVlYTMwMjIxM2YiPjxyZWN0IHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjNzc3Ii8+PGc+PHRleHQgeD0iMzA4LjI5Njg3NSIgeT0iMjcwLjEiPkZpcnN0IHNsaWRlPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true">
                                            <div class="carousel-caption">
                                                <h3>...</h3>
                                                <p>...</p>
                                            </div>
                                        </div>
                                        <div class="item active">
                                            <img data-src="holder.js/900x500/auto/#666:#444/text:Second slide" alt="Second slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNjY2OiM0NDQvdGV4dDpTZWNvbmQgc2xpZGUKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNWVhMzAyMjkzNyB0ZXh0IHsgZmlsbDojNDQ0O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQ1cHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1ZWEzMDIyOTM3Ij48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiIvPjxnPjx0ZXh0IHg9IjI2NC45NTMxMjUiIHk9IjI3MC4xIj5TZWNvbmQgc2xpZGU8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                            <div class="carousel-caption">
                                                <h3>...</h3>
                                                <p>...</p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img data-src="holder.js/900x500/auto/#555:#333/text:Third slide" alt="Third slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNTU1OiMzMzMvdGV4dDpUaGlyZCBzbGlkZQpDcmVhdGVkIHdpdGggSG9sZGVyLmpzIDIuNi4wLgpMZWFybiBtb3JlIGF0IGh0dHA6Ly9ob2xkZXJqcy5jb20KKGMpIDIwMTItMjAxNSBJdmFuIE1hbG9waW5za3kgLSBodHRwOi8vaW1za3kuY28KLS0+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj48IVtDREFUQVsjaG9sZGVyXzE1ZWEzMDFmNjk4IHRleHQgeyBmaWxsOiMzMzM7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6NDVwdCB9IF1dPjwvc3R5bGU+PC9kZWZzPjxnIGlkPSJob2xkZXJfMTVlYTMwMWY2OTgiPjxyZWN0IHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjNTU1Ii8+PGc+PHRleHQgeD0iMjk4LjMyMDMxMjUiIHk9IjI3MC4xIj5UaGlyZCBzbGlkZTwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true">
                                            <div class="carousel-caption">
                                                <h3>...</h3>
                                                <p>...</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="left carousel-control" href="#carousel-news" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-news" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                            {{--日程安排--}}
                            <div class="index-page-display-part">
                                <div id="index-calender">

                                </div>
                            </div>
                        </section>

                        {{--<div class="col-sm-7">--}}

                        {{--</div>--}}

                        {{--<div class="col-sm-5">--}}

                        {{--</div>--}}

                        {{--<div class="col-sm-7">--}}

                        {{--</div>--}}
                    </div>
                </div>
            </div>
                {{--<p>需要展示的有：</p>--}}
                {{--<p>1、新闻／通知公告</p>--}}
                {{--<p>6、图片新闻轮播图</p>--}}
                {{--<p>2、待办事项／已完结事项</p>--}}
                {{--<p>3、待阅公文／已阅公文</p>--}}
                {{--<p>4、常用流程</p>--}}
                {{--<p>5、日程安排</p>--}}
        </div>
    </section>
    <script>
        $('#index-calender').fullCalendar({
            themeSystem: 'bootstrap3',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: '今天',
                month: '月',
                week: '周',
                day: '日'
            },
            views: {
                month: {
                    columnFormat: 'ddd'
                },
                week: {
                    columnFormat: 'ddd M/D'
                },
                day: {
                    columnFormat: 'ddd'
                }
            },
            businessHours: {
                start: '08:00',
                end: '18:00'
            },
            firstDay: 0,
            height: 'auto',
            contentHeight: 'auto',
            editable: true,
            eventLimit: true,
            eventLimitText: ' 个日程',

            windowResize: function(view) {
//                alert('The calendar has adjusted to a window resize');
            },
            dayClick: function(date, jsEvent, view) {
                console.log('Clicked on: ' + date.format());
                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                console.log('Current view: ' + view.name);
                // change the day's background color just for fun
                $(this).css('background-color', 'red');

            },

            eventClick: function(calEvent, jsEvent, view) {
                console.log('Event: ' + calEvent.title);
                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                console.log('View: ' + view.name);
                // change the border color just for fun
                $(this).css('border-color', 'red');

            },

            events: [
                {
                    title: 'All Day Event',
                    start: '2017-09-21',
                    backgroundColor: "#f56954", //red
                    borderColor: "#f56954" //red
                },
                {
                    title: 'Meeting',
                    start: '2017-09-21 10:30',
                    end: '2017-09-21 11:30',
                    allDay: false,
                    backgroundColor: "#0073b7", //Blue
                    borderColor: "#0073b7" //Blue
                },
                {
                    title: 'Meeting',
                    start: '2017-09-21 10:30',
                    end: '2017-09-21 11:30',
                    allDay: false,
                    backgroundColor: "#0073b7", //Blue
                    borderColor: "#0073b7" //Blue
                }
            ]
        });
    </script>
@endsection