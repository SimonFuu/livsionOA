@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">职位管理</h3>
                <div class="box-tools">
                    <a href="/system/positions/add" class="btn btn-sm btn-primary">添加</a>
                    <a href="/system/positions/delete" class="btn btn-danger btn-sm delete-position">删除</a>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="positions">
                                <table class="table table-bordered table-condensed table-hover text-center positions-list">
                                    <thead>
                                        <tr>
                                            <th width="20">ID</th>
                                            <th width="50">职位</th>
                                            <th width="50">状态</th>
                                        </tr>
                                    </thead>
                                    <tbody class="positions-list-body">
                                        @foreach($positions as $position)
                                            <tr data-p-id="{{ $position -> id }}">
                                                <td>{{ $position -> id }}</td>
                                                <td>{{ $position -> positionName }}</td>
                                                <td>{{ $position -> status == 1 ? '启用' : '禁用' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="positions positions-form">
                                {!! Form::open(['url' => '/system/positions/store', 'method' => 'POST', 'class' => 'form-horizontal positions-submit-form', 'role' => 'form']) !!}
                                    <!-- class include {'form-horizontal'|'form-inline'} -->
                                    <!--- PositionName Field --->
                                    <div class="form-group">
                                        {!! Form::label('positionName', '职位名称 * ：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('positionName', null, ['class' => 'form-control ed-positionName', 'placeholder' => '请输入职位名称！']) !!}
                                        </div>
                                    </div>

                                    <!--- Weight Field --->
                                    <div class="form-group">
                                        {!! Form::label('weight', '权重：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('weight', 100, ['class' => 'form-control ed-weight', 'placeholder' => '请输入0-100的数字作为展示权重，数字越小越靠前！']) !!}
                                        </div>
                                    </div>
                                    <!--- Status Field --->
                                    <div class="form-group">
                                        {!! Form::label('status', '是否启用：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('status', ['禁用', '启用'], 1, ['class' => 'form-control ed-status']) !!}

                                        </div>
                                    </div>

                                    <!--- Description Field --->
                                    <div class="form-group">
                                        {!! Form::label('description', '描述：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::textarea('description', null, ['class' => 'form-control ed-description', 'rows' => 5, 'placeholder' => '请输入职位描述！']) !!}
                                        </div>
                                    </div>

                                    <input type="hidden" class="ed-id" name="id" value="-1">

                                    <!--- Submit Field --->
                                    <div class="form-group">
                                        <div class="col-md-offset-4">
                                            <button class="btn btn-primary" type="submit">提交</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
    <!-- add-positions-modal -->
    <div class="modal fade" id="addPositionsFormModal" tabindex="-1" role="dialog" aria-labelledby="addPositionsFormModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addPositionsFormModalLabel">添加职位</h4>
                </div>
                {!! Form::open(['url' => '/system/positions/store', 'method' => '', 'class' => 'form-horizontal positions-submit-form', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="modal-body">

                        <!--- PositionName Field --->
                        <div class="form-group">
                            {!! Form::label('positionName', '职位名称 * ：', ['class' => 'control-label col-sm-2']) !!}
                            <div class="col-md-8">
                                {!! Form::text('positionName', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!--- Weight Field --->
                        <div class="form-group">
                            {!! Form::label('weight', '权重：', ['class' => 'control-label col-md-4']) !!}
                            <div class="col-md-8">
                                {!! Form::number('weight', 100, ['class' => 'form-control', 'placeholder' => '请输入0-100的数字作为展示权重，数字越小越靠前！']) !!}
                            </div>
                        </div>
                        <!--- Status Field --->
                        <div class="form-group">
                            {!! Form::label('status', '是否启用：', ['class' => 'control-label col-md-4']) !!}
                            <div class="col-md-8">
                                {!! Form::select('status', ['禁用', '启用'], 1, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!--- Description Field --->
                        <div class="form-group">
                            {!! Form::label('description', '描述：', ['class' => 'control-label col-md-4']) !!}
                            <div class="col-md-8">
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '请输入职位描述！']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">提交</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- /.select-parent-department-modal -->
@endsection