@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">用户列表</h3>

                <div class="box-tools">
                    <a href="/system/users/add" class="btn btn-primary btn-sm">添加</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <div class="search-header">
                    {!! Form::open(['url' => '/system/users/list', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                        <!--- Name Field --->
                        <div class="form-group form-group-sm">
                            {!! Form::label('name', '姓名:', ['class' => 'control-label']) !!}
                            {!! Form::text('name', isset($sCondition['name']) ? $sCondition['name'] : null, ['class' => 'form-control', 'placeholder' => '请输入姓名！']) !!}
                        </div>
                        <!--- Telephone Field --->
                        <div class="form-group form-group-sm">
                            {!! Form::label('telephone', '电话:', ['class' => 'control-label']) !!}
                            {!! Form::text('telephone', isset($sCondition['telephone']) ? $sCondition['telephone'] : null, ['class' => 'form-control', 'placeholder' => '请输入电话！']) !!}
                        </div>
                        <!--- Gender Field --->
                        <div class="form-group form-group-sm">
                            {!! Form::label('gender', '性别:', ['class' => 'control-label']) !!}
                            {!! Form::select('gender', [-1 => '请选择', '男', '女'], isset($sCondition['gender']) ? $sCondition['gender'] : null, ['class' => 'form-control', 'placeholder' => '请选择']) !!}
                        </div>
                        <!--- IsAdmin Field --->
                        <div class="form-group form-group-sm">
                            {!! Form::label('isAdmin', '管理员:', ['class' => 'control-label']) !!}
                            {!! Form::select('isAdmin', [-1 => '请选择', '否', '是'], isset($sCondition['isAdmin']) ? $sCondition['isAdmin'] : null, ['class' => 'form-control']) !!}
                        </div>
                        <input type="submit" class="btn btn-info btn-sm" value="查询">
                    {!! Form::close() !!}
                    <hr>
                </div>
                {{--'id', 'name', 'gender', 'isAdmin', 'telephone', 'email', 'isDelete'--}}
                <table class="table table-hover actions-list">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th width="100">姓名</th>
                            <th width="50">性别</th>
                            <th width="100">电话</th>
                            <th width="200">邮箱</th>
                            <th width="50">管理员</th>
                            <th width="50">状态</th>
                            <th width="50">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user -> id }}</td>
                                <td>{{ $user -> name }}</td>
                                <td>{{ $user -> gender ? '男' : '女' }}</td>
                                <td>{{ $user -> telephone }}</td>
                                <td>{{ $user -> email }}</td>
                                <td>{{ $user -> isAdmin ? '是' : '否' }}</td>
                                <td>{{ $user -> isDelete ? '<span class="badge bg-red">已删除</span>' : '<span class="badge bg-green">正常</span>'}}</td>
                                <td>
                                    <a href="/system/users/edit?id={{ $user -> id }}"><i class="fa fa-pencil-square-o"></i></a>
                                    &nbsp;
                                    <a href="/system/users/delete?id={{ $user -> id }}"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                {{ $users -> appends(empty($sCondition) ? null : $sCondition) ->links() }}
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection