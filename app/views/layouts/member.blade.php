@extends('layouts.master')
@section('css')
	@yield('mcss')
@stop
@section('wapper')
    <link rel="stylesheet" href="/style/css/new/base.css">
	<script>
	var parentId = 'null'
	</script>
	<script src="/style/common/js/constant.js"></script>
	<script src="/style/js/login.js"></script>
	<!-- 面包屑 -->
	<div class="bread wrap">
		<a href="/">首页</a>>@yield('mianbaoxie')
	</div>
	<!-- 内容部分 -->
	<div class="content wrap fn-clear">


		<script src="/style/common/js/jquery.cookie.js"></script>

		<div class="fn-left left">
    		@include('partial.mlefter')
		</div>
		<script>
		console.log(parentId);
		if(parentId != null && parentId != "" && parentId != 'null')
		{

		}
		else
		{
			if(0.0 > 0){
				$('.balance').html(0.0+"元");
			}

		}
		</script>
		<div class="fn-right right">
			@yield('right')
		</div>
		@yield('right-outter')
	</div>
@stop
