@extends('layouts.layout')
@section('body')
    <section class="content">
        <div class="index-container">
            <div class="row">
                <section class="col-md-7 connectedSortable ui-sortable">
                    {{--新闻与通知公告--}}
                    <div class="box news-and-announcement">
                        <div class="box-header nav-tabs-custom">
                            <ul id="news-tab" class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#news-list" class="tabs-button" id="news-list-tab" role="tab" data-toggle="tab" data-read-more="/news/list" aria-controls="news-list" aria-expanded="true">
                                        新闻
                                        <span class="label label-danger">1</span>
                                    </a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#announcements-list" class="tabs-button" role="tab" id="announcements-list-tab" data-read-more="/announcements/list" data-toggle="tab" aria-controls="announcements-list" aria-expanded="false">
                                        通知公告
                                        <span class="label label-danger">1</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
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
                            <div class="read-more text-right">
                                <a href="/news/list" class="">
                                    更多 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{--待办事项--}}
                    <div class="box to-dos">
                        <div class="box-header nav-tabs-custom">
                            <ul id="to-dos-tab" class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#to-dos-list" class="tabs-button" id="to-dos-list-tab" role="tab" data-toggle="tab" data-read-more="/matters/list/todo" aria-controls="to-dos-list" aria-expanded="true">待办事项</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#has-done-list" class="tabs-button" role="tab" id="has-done-list-tab" data-toggle="tab" data-read-more="/matters/list/done" aria-controls="has-done-list" aria-expanded="false">已完结事项</a>
                                </li>
                            </ul>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
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
                            <div class="read-more text-right">
                                <a href="/matters/list/todo" class="">
                                    更多 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                </a>
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
                                <div class="item active">
                                    <a href="#">
                                        <img data-src="holder.js/900x500/auto/#777:#555/text:First slide" alt="First slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNzc3OiM1NTUvdGV4dDpGaXJzdCBzbGlkZQpDcmVhdGVkIHdpdGggSG9sZGVyLmpzIDIuNi4wLgpMZWFybiBtb3JlIGF0IGh0dHA6Ly9ob2xkZXJqcy5jb20KKGMpIDIwMTItMjAxNSBJdmFuIE1hbG9waW5za3kgLSBodHRwOi8vaW1za3kuY28KLS0+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj48IVtDREFUQVsjaG9sZGVyXzE1ZWEzMDIyMTNmIHRleHQgeyBmaWxsOiM1NTU7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6NDVwdCB9IF1dPjwvc3R5bGU+PC9kZWZzPjxnIGlkPSJob2xkZXJfMTVlYTMwMjIxM2YiPjxyZWN0IHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjNzc3Ii8+PGc+PHRleHQgeD0iMzA4LjI5Njg3NSIgeT0iMjcwLjEiPkZpcnN0IHNsaWRlPC90ZXh0PjwvZz48L2c+PC9zdmc+" data-holder-rendered="true">
                                        <div class="carousel-caption">
                                            <p>...</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <img data-src="holder.js/900x500/auto/#666:#444/text:Second slide" alt="Second slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNjY2OiM0NDQvdGV4dDpTZWNvbmQgc2xpZGUKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNWVhMzAyMjkzNyB0ZXh0IHsgZmlsbDojNDQ0O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjQ1cHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1ZWEzMDIyOTM3Ij48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiIvPjxnPjx0ZXh0IHg9IjI2NC45NTMxMjUiIHk9IjI3MC4xIj5TZWNvbmQgc2xpZGU8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" data-holder-rendered="true">
                                        <div class="carousel-caption">
                                            <p>...</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#">
                                        <img data-src="holder.js/900x500/auto/#555:#333/text:Third slide" alt="Third slide [900x500]" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDkwMCA1MDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzkwMHg1MDAvYXV0by8jNTU1OiMzMzMvdGV4dDpUaGlyZCBzbGlkZQpDcmVhdGVkIHdpdGggSG9sZGVyLmpzIDIuNi4wLgpMZWFybiBtb3JlIGF0IGh0dHA6Ly9ob2xkZXJqcy5jb20KKGMpIDIwMTItMjAxNSBJdmFuIE1hbG9waW5za3kgLSBodHRwOi8vaW1za3kuY28KLS0+PGRlZnM+PHN0eWxlIHR5cGU9InRleHQvY3NzIj48IVtDREFUQVsjaG9sZGVyXzE1ZWEzMDFmNjk4IHRleHQgeyBmaWxsOiMzMzM7Zm9udC13ZWlnaHQ6Ym9sZDtmb250LWZhbWlseTpBcmlhbCwgSGVsdmV0aWNhLCBPcGVuIFNhbnMsIHNhbnMtc2VyaWYsIG1vbm9zcGFjZTtmb250LXNpemU6NDVwdCB9IF1dPjwvc3R5bGU+PC9kZWZzPjxnIGlkPSJob2xkZXJfMTVlYTMwMWY2OTgiPjxyZWN0IHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjNTU1Ii8+PGc+PHRleHQgeD0iMjk4LjMyMDMxMjUiIHk9IjI3MC4xIj5UaGlyZCBzbGlkZTwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true">
                                        <div class="carousel-caption">
                                            <p>...</p>
                                        </div>
                                    </a>
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
                    <div class="box calendar">
                        <div class="box-header">
                            <i class="fa fa-calendar"></i> 日程安排
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div id="index-calender">

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{--<p>需要展示的有：</p>--}}
        {{--<p>1、新闻／通知公告</p>--}}
        {{--<p>6、图片新闻轮播图</p>--}}
        {{--<p>2、待办事项／已完结事项</p>--}}
        {{--<p>3、待阅公文／已阅公文</p>--}}
        {{--<p>4、常用流程</p>--}}
        {{--<p>5、日程安排</p>--}}
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addEvent" tabindex="-1" role="dialog" aria-labelledby="addEventLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addEventLabel">创建日程</h4>
                </div>
                {!! Form::open(['url' => '/url', 'method' => 'POST', 'class' => 'form-horizontal modal-form', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="modal-body">
                        <!--- Title Field --->
                        <div class="form-group add-event-form-group">
                            {!! Form::label('title', '标题：', ['class' => 'control-label']) !!}
                            {!! Form::text('title', null, ['class' => 'form-control']) !!}
                        </div>

                        <!--- DayEvent Field --->
                        <div class="form-group add-event-form-group">
                            {!! Form::label('dayEvent', '全天事件:', ['class' => 'control-label']) !!}
                            <div>
                                <label class="radio-inline">
                                    {!! Form::radio('dayEvent', 1, 'checked') !!}是
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('dayEvent', 0) !!}否
                                </label>
                            </div>
                        </div>

                        <!--- StartEnd Field --->
                        <div class="form-group add-event-form-group">
                            {!! Form::label('startEnd', '起止时间：', ['class' => 'control-label']) !!}
                            {!! Form::text('startEnd', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group add-event-form-group">
                            {!! Form::label('dayEvent', '事件标识:', ['class' => 'control-label']) !!}
                            <a class="text-teal" href="javascript:;"><i class="fa fa-square"></i></a>
                            <ul class="fc-color-picker" id="color-chooser">
                                <li><a class="text-blue" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-light-blue" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-teal" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-yellow" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-orange" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-green" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-lime" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-red" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-purple" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-fuchsia" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-muted" href="javascript:;"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-navy" href="javascript:;"><i class="fa fa-square"></i></a></li>
                            </ul>
                            <input type="hidden" name="eventColor" id="">
                        </div>

                        <!--- Description Field --->
                        <div class="form-group add-event-form-group">
                            {!! Form::label('description', '描述:', ['class' => 'control-label']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary">提交</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>

        console.log($('.text-blue').css('color'));
        $('input[name="startEnd"]').daterangepicker({
            timePicker: 0,
            timePickerIncrement: 10,
            startDate: '2017-09-22 15',
            endDate: '2017-09-22 16',
            minDate: '2017-09-22 15',
            timePicker24Hour: true,
            format: 'YYYY-MM-DD H:mm',
            locale: {
                format: 'YYYY-MM-DD H:mm'
            },
            opens: "left"

        }, function (start, end) {
            alert(start.format('YYYY-MM-DD'));
            alert(end.format('YYYY-MM-DD'));
        });

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
            editable: false,
            eventLimit: true,
            eventLimitText: ' 个日程',

            dayClick: function(date, jsEvent, view) {
                console.log('Clicked on: ' + date.format());
                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                console.log('Current view: ' + view.name);
                var today=new Date();
                var year=today.getFullYear();
                var month=today.getMonth()+1;
                var day=today.getDate();
                if(month<=9){
                    month="0"+month;
                }
                if(day<=9){
                    day="0"+day;
                }
                today=year+"-"+month+"-"+day;
                if (date.format() >= today) {
                    $('#addEvent').modal('show');
                } else {
                    alert('无法在之前的日期中创建日程！');
                }
            },

            eventClick: function(event, jsEvent, view) {
                console.log('Event: ' + event.id);
                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                console.log('View: ' + view.name);
                $(this).css('border-color', 'red');
            },

            events: [
                {
                    id: 1,
                    title: 'All Day Event',
                    start: '2017-09-21',
                    backgroundColor: "#f56954", //red
                    borderColor: "#f56954" //red
                },
                {
                    id: 2,
                    title: 'Meeting',
                    start: '2017-09-21 10:30',
                    end: '2017-09-21 11:30',
                    allDay: false,
                    backgroundColor: "#0073b7", //Blue
                    borderColor: "#0073b7" //Blue
                },
                {
                    id: 3,
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