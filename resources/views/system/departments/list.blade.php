@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">组织结构</h3>
                <div class="box-tools">
                    <a href="/system/departments/add" class="btn btn-primary btn-sm">添加</a>
                    <a href="/system/departments/delete" class="btn btn-danger btn-sm delete-department">删除</a>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="departments departments-tree-menu">
                                {{--List Html由 Controller 生成--}}
                                {!! $departmentsHtml !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="departments">
                                {!! Form::open(['url' => '/system/departments/store', 'method' => 'POST', 'class' => 'form-horizontal departments-submit-form', 'role' => 'form']) !!}
                                <!-- class include {'form-horizontal'|'form-inline'} -->
                                    <!--- DepartmentName Field --->
                                    <div class="form-group {{ $errors -> has('departmentName') ? 'has-error' : '' }}">
                                        {!! Form::label('departmentName', '名称 * ：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('departmentName', null, ['class' => 'form-control', 'placeholder' => '请输入名称']) !!}
                                            @if($errors -> has('departmentName'))
                                                <span class="help-block">
                                                    <strong>{{ $errors -> first('departmentName') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!--- ParentDepartment Field --->
                                    <div class="form-group {{ $errors -> has('parentDepartment') ? 'has-error' : '' }}">
                                        {!! Form::label('parentDepartment', '上级部门 * ：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <label for="parentDepartmentName"></label>
                                                <input type="text" class="form-control" id="parentDepartmentName" placeholder="请选择上级部门" value="" readonly>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-success selectParentDepartmentButton" type="button" disabled="disabled" data-toggle="modal" data-target="#selectParentDepartmentModal">选择</button>
                                                </div>
                                                <input type="hidden" name="parentDepartment" value="">
                                            </div>
                                            <span class="help-block">
                                                <strong>{{ $errors -> first('parentDepartment') }}</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <!--- weight Field --->
                                    <div class="form-group {{ $errors -> has('weight') ? 'has-error' : '' }}">
                                        {!! Form::label('weight', '展示权重：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('weight', 100, ['class' => 'form-control', 'placeholder' => '请输入0-100的数字，数字越小，展示越靠前']) !!}
                                            <span class="help-block">
                                                <strong>{{ $errors -> first('weight') }}</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <!--- Description Field --->
                                    <div class="form-group {{ $errors -> has('description') ? 'has-error' : '' }}">
                                        {!! Form::label('description', '描述：', ['class' => 'control-label col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5, 'placeholder' => '请输入部门描述！']) !!}
                                            <span class="help-block">
                                                <strong>{{ $errors -> first('description') }}</strong>
                                            </span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="-1">
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
    <!-- select-parent-department-modal -->
    <div class="modal fade" id="selectParentDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="selectParentDepartmentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="selectParentDepartmentModalLabel">请选择上级部门</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <ul class="tree-menu">
                            <li>
                                {!! $departmentsHtml !!}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.select-parent-department-modal -->
@endsection