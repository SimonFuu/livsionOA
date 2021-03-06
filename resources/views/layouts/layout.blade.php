<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Starter</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @if(env('APP_ENV') === 'local')
        <link rel="stylesheet" href="/assets/plugins/bootstrap-3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/plugins/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="/assets/plugins/AdminLte/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/assets/plugins/AdminLte/css/skin-blue.min.css">
        <link rel="stylesheet" href="/assets/css/layouts.css?v={{ date('YmdHi') }}">
        <script src="/assets/plugins/jquery-3.2.1/jquery-3.2.1.min.js"></script>
        <script src="/assets/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    @else
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
        <link href="//cdn.bootcss.com/admin-lte/2.3.11/css/AdminLTE.min.css" rel="stylesheet">
        <link href="//cdn.bootcss.com/admin-lte/2.3.11/css/skins/skin-blue.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/layouts.css?v={{ env('APP_ASSETS_VERSION') }}">
        <script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @endif
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper iframe-content-warpper">
        @yield('body')
    </div>

    <!-- /.content-wrapper -->


    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
@if(env('APP_ENV') === 'local')
    <script src="/assets/plugins/AdminLte/js/app.min.js"></script>
    <script src="/assets/js/app.js?v={{ date('YmdHi') }}"></script>
@else
    <script src="//cdn.bootcss.com/admin-lte/2.3.11/js/app.min.js"></script>
    <script src="/assets/js/app.js?v={{ env('APP_ASSETS_VERSION') }}"></script>
@endif
</body>
</html>