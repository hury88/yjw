<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <title>@section('title') {{$system_seotitle}} @show</title>
    <meta name="keywords" content="{{$system_keywords}}">
    <meta name="description" content="{{$system_description}}">
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    @yield('css')
</head>
<body>
{{-- Navigation bar section --}}
@section('navigation')
    @include('partial.navigation')
@show

{{-- Breadcrumbs section --}}
@section('breadcrumbs')
@show

{{-- Content page --}}
@yield('wapper')

@section('footer') {{-- 底部开始 --}}
@include('partial.footer')
@show {{-- 底部结束 --}}
@section('scripts')
@show
</body>
</html>