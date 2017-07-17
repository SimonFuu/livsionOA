<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Livsion OA System</title>
    @if(env('APP_ENV') === 'local')
        <link rel="stylesheet" href="assets/plugins/bootstrap-3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/plugins/fontawesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/layouts.css?v={{ date('YmdHi') }}">
        <script src="assets/plugins/jquery-3.2.1/jquery-3.2.1.min.js"></script>
        <script src="assets/plugins/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    @else
        <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="assets/css/layouts.css?v={{ env('APP_ASSETS_VERSION') }}" rel="stylesheet">
        <script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @endif
</head>
<body>
@yield('body')

@if(env('APP_ENV') === 'local')
    <script src="assets/js/app.js?v={{ date('YmdHi') }}"></script>
@else
    <script src="assets/js/app.js?v={{ env('APP_ASSETS_VERSION') }}"></script>
@endif
</body>
</html>