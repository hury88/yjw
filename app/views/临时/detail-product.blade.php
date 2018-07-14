@extends('layouts.public')

@section('css')
<link rel="stylesheet" href="/style/css/product.css"/>
<script type="text/javascript" src="/style/js/jquery1.42.min.js"></script>
<script type="text/javascript" src="/style/js/jquery.SuperSlide.2.1.1.js"></script>
@stop
@section('right')
<div class="pro-list-deatil">
	<div class="langchao">
		<div class="langchao-lt fl">
			<h1>{{$view->title}}</h1>
			<h3>产品特征：</h3>
			<p>{!! $view->introduce !!}</p>
		</div>
		<div class="langchao-rt fr">
			<img src="{{$view->img1}}">
		</div>
	</div>

	<div class="picScroll-left">
		<div class="hd">
			<a class="next"></a>
			<ul></ul>
			<a class="prev"></a>
		</div>
		<div class="bd">
			<ul class="picList">
				{!! vv_data(\App\helpers\VV::pic($view->id),
				'
				<li>
					<div class="pic"><a href="javascript:;"><img src="__IMG__" /></a></div>
				</li>

				') !!}
			</ul>
		</div>
	</div>

	<script type="text/javascript">
	jQuery(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:false,vis:3,trigger:"click"});
	</script>

	<div class="langchao_bot clr">
		{!! $view->content !!}
	</div>
</div>

@stop
@section('scripts')
@stop