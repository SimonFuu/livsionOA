@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">添加职位</h3>
            </div>

            {!! Form::open(['url' => '/system/positions/store', 'method' => 'POST', 'class' => 'form-horizontal positions-submit-form', 'role' => 'form']) !!}
            <!-- class include {'form-horizontal'|'form-inline'} -->
                <div class="box-body">
                    <!--- PositionName Field --->
                    <div class="form-group">
                        {!! Form::label('positionName', '职位名称 * ：', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('positionName', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!--- Weight Field --->
                    <div class="form-group">
                        {!! Form::label('weight', '权重：', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('weight', 100, ['class' => 'form-control', 'placeholder' => '请输入0-100的数字作为展示权重，数字越小越靠前！']) !!}
                        </div>
                    </div>
                    <!--- Status Field --->
                    <div class="form-group">
                        {!! Form::label('status', '是否启用：', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('status', ['禁用', '启用'], 1, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <!--- Description Field --->
                    <div class="form-group">
                        {!! Form::label('description', '描述：', ['class' => 'control-label col-sm-2']) !!}
                        <div class="col-sm-10">
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '请输入职位描述！']) !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <a href="/system/positions/list" class="btn btn-default">返回</a>
                    <button class="btn btn-info pull-right" type="submit">提交</button>
                </div>
            {!! Form::close() !!}
        </div>
    </section>
    <!-- /.content -->
@endsection