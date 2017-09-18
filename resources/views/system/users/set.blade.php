@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box box-{{ is_null($user) ? 'info' : 'primary' }}">
            <div class="box-header with-border">
                <h3 class="box-title">{{ is_null($user) ? '添加' : '编辑'}}员工</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['url' => '/system/users/store', 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                <div class="box-body">
                    <div class="form-group">
                        <!--- Username Field --->
                        <div class="user-form-group {{ $errors -> has('username') ? 'has-error' : '' }}">
                            {!! Form::label('username', '工号(*):', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('username', is_null($user) ? null : $user -> username, ['class' => 'form-control', 'placeholder' => '请输入工号！', is_null($user) ? '' : 'readonly']) !!}
                                @if($errors -> has('username'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('username') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <!--- Name Field --->
                        <div class="user-form-group user-bottom-form-group {{ $errors -> has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', '姓名(*):', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('name', is_null($user) ? null : $user -> name, ['class' => 'form-control', 'placeholder' => '请输入用户姓名！']) !!}
                                @if($errors -> has('name'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!--- Password Field --->
                    <div class="form-group">
                        <div class="user-form-group {{ $errors -> has('password') ? 'has-error' : '' }}">
                            {!! Form::label('password', '密码' . (is_null($user) ? '(*):' : ':'), ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '请输入密码！']) !!}
                                @if($errors -> has('password'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('password') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="user-form-group user-bottom-form-group {{ $errors -> has('password') ? 'has-error' : '' }}">
                            {!! Form::label('password', '确认密码' . (is_null($user) ? '(*):' : ':'), ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => '请重新输入密码！']) !!}
                                @if($errors -> has('password'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--- Telephone Field --->
                        <div class="user-form-group user-bottom-form-group {{ $errors -> has('telephone') ? 'has-error' : '' }}">
                            {!! Form::label('telephone', '手机号(*):', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::number('telephone', is_null($user) ? null : $user -> telephone, ['class' => 'form-control', 'placeholder' => '请输入用户手机号！']) !!}
                                @if($errors -> has('telephone'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('telephone') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--- UserDepartment Field --->
                        <div class="user-form-group {{ $errors -> has('departmentId') ? 'has-error' : '' }}">
                            {!! Form::label('departmentId', '所属部门(*):', ['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <label for="departmentName"></label>
                                    <input type="text" class="form-control" id="departmentName" placeholder="请选择部门" value="{{ is_null($user) ? '' : $user -> departmentName }}" readonly>
                                    <div class="input-group-btn">
                                        <button class="btn btn-success selectUserDepartmentButton" type="button" data-toggle="modal" data-target="#selectUserDepartmentModal">选择</button>
                                    </div>
                                    <input type="hidden" name="departmentId" value="{{ is_null($user) ? '' : $user -> departmentId }}">
                                </div>
                                @if($errors -> has('departmentId'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('departmentId') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!--- PositionId Field --->
                        <div class="user-form-group user-bottom-form-group {{ $errors -> has('positionId') ? 'has-error' : '' }}">
                            {!! Form::label('positionId', '职位(*):', ['class' => 'control-label col-sm-2']) !!}
                            <div class="col-sm-3">
                                {!! Form::select('positionId', $positions, is_null($user) ? 1 : $user -> positionId, ['class' => 'form-control']) !!}
                            </div>
                            @if($errors -> has('positionId'))
                                <span class="help-block form-help-block"><strong>{{ $errors -> first('positionId') }}</strong>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <!--- officeTel Field --->
                        <div class="user-form-group {{ $errors -> has('officeTel') ? 'has-error' : '' }}">
                            {!! Form::label('officeTel', '办公电话:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::text('officeTel', is_null($user) ? null : $user -> officeTel, ['class' => 'form-control', 'placeholder' => '请输入办公电话！']) !!}
                                @if($errors -> has('officeTel'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('officeTel') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <!--- Email Field --->
                        <div class="user-form-group user-bottom-form-group {{ $errors -> has('email') ? 'has-error' : '' }}">
                            {!! Form::label('email', '邮箱:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                {!! Form::email('email', is_null($user) ? null : $user -> email, ['class' => 'form-control', 'placeholder' => '请输入用户邮箱！']) !!}
                                @if($errors -> has('email'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <!--- Gender Field --->
                        <div class="user-form-group {{ $errors -> has('gender') ? 'has-error' : '' }}">
                            {!! Form::label('gender', '性别:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-2">
                                <label class="radio-inline">
                                    {!! Form::radio('gender', 0, is_null($user) ? 'checked' : ($user -> gender == 0 ? 'checked' : '')) !!}男
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('gender', 1, (!is_null($user) && $user -> gender == 1) ? 'checked' : '') !!}女
                                </label>
                                @if($errors -> has('gender'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('gender') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <!--- Gender Field --->
                        <div class="user-form-group {{ $errors -> has('gender') ? 'has-error' : '' }}">
                            {!! Form::label('status', '状态:', ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-2">
                                <label class="radio-inline">
                                    {!! Form::radio('status', 1, is_null($user) ? 'checked' : ($user -> status == 1 ? 'checked' : '')) !!}启用
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('status', 0, (!is_null($user) && $user -> status == 0) ? 'checked' : '') !!}禁用
                                </label>
                                @if($errors -> has('gender'))
                                    <span class="help-block form-help-block"><strong>{{ $errors -> first('gender') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!--- IsAdmin Field --->
                    <div class="form-group {{ $errors -> has('isAdmin') ? 'has-error' : '' }}">
                        {!! Form::label('isAdmin', '是否是管理员:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <label class="radio-inline">
                                {!! Form::radio('isAdmin', 1, (!is_null($user) && $user -> isAdmin == 1) ? 'checked' : '') !!}是
                            </label>
                            <label class="radio-inline">
                                {!! Form::radio('isAdmin', 0, is_null($user) ? 'checked' : ($user -> isAdmin == 0 ? 'checked' : '')) !!}否
                            </label>
                            @if($errors -> has('isAdmin'))
                                <span class="help-block form-help-block"><strong>{{ $errors -> first('isAdmin') }}</strong></span>
                            @endif
                        </div>
                    </div>

                    <!--- UserRoles Field --->
                    <div class="form-group admin-roles {{ $errors -> has('roles') ? 'has-error' : '' }}">
                        {!! Form::label('roles', '用户角色:', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <div class="user-roles-list">
                                @foreach($roles as $role)
                                    <div class="col-sm-2">
                                        <table class="table table-bordered table-condensed user-roles-list-table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            @if(is_null($user))
                                                                <input type="checkbox" name="roles[]" value="{{ $role -> id }}">&nbsp;&nbsp;{{ $role -> roleName }}
                                                            @else
                                                                <input type="checkbox" name="roles[]" value="{{ $role -> id }}" {{ in_array($role -> id, $user -> roles) ? 'checked' : ''}}>&nbsp;&nbsp;{{ $role -> roleName }}
                                                            @endif
                                                        </label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                            @if($errors -> has('roles'))
                                <span class="help-block form-help-block"><strong>{{ $errors -> first('roles') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    @if(!is_null($user))
                        <input type="hidden" name="id" value="{{ $user -> id }}">
                    @endif
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="/system/users/list" class="btn btn-default">返回</a>
                    <button type="submit" class="btn btn-{{ is_null($user) ? 'info' : 'primary' }} pull-right">提交</button>
                </div>
                <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </section>
    <!-- /.content -->
    <!-- select-parent-department-modal -->
    <div class="modal fade" id="selectUserDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="selectUserDepartmentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="selectUserDepartmentModalLabel">请选择所属部门</h4>
                </div>
                <div class="modal-body">
                    <div class="departments-list-on-modal">
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