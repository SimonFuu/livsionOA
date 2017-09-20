@extends('layouts.layout')
@section('body')
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">通讯录</h3>
                <div class="box-tools">
                    {!! Form::open(['url' => '/contacts/index', 'method' => 'GET', 'role' => 'form']) !!}
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="name" value="{{ isset($query['name']) ? $query['name'] : '' }}" class="form-control pull-right" placeholder="请输入姓名">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="contacts-departments">
                                {!! $departmentsHtml !!}
                                @if(isset($query['did']))
                                    <script>var currentDID = '{{ $query['did'] }}'</script>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="contacts-list">
                                <table class="table table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th width="50">工号</th>
                                        <th width="100">姓名</th>
                                        <th width="100">部门</th>
                                        <th width="100">职位</th>
                                        <th width="100">手机</th>
                                        <th width="100">办公电话</th>
                                        <th width="100">邮箱</th>
                                    </tr>
                                    </thead>
                                    <tbody class="contacts-list-body">
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user -> username }}</td>
                                                <td>{{ $user -> name }}</td>
                                                <td>{{ $user -> departmentName }}</td>
                                                <td>{{ $user -> positionName }}</td>
                                                <td>{{ $user -> telephone }}</td>
                                                <td>{{ $user -> officeTel ? $user -> officeTel : '空' }}</td>
                                                <td>{{ $user -> email ? $user -> email : '空'}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="box-footer clearfix contacts-list-pagination">
                                {{ $users -> appends($query) -> links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection