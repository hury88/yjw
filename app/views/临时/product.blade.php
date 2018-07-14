@extends('layouts.public')

@section('css')
<link rel="stylesheet" href="/style/css/product.css"/>
<style>
    .product-img-box {width: 420px;height: 170px;display: flex;align-items: center;justify-content: center;}
    .product-img-box img{max-width: 100%; max-height: 100%;}
</style>
@stop
@section('right')
<div class="pro-list2">{{-- 一级列表页 --}}
    <ul class="clr">
        {!! vv_data(M('news_cats')->where('pid='.$ty)->field('id,img1,catname,description')->order('disorder desc, id asc')->select(), '
        <li>
            <a class="product-img-box" href="/web/index?pid='.$ty.'&ty=@$id@"><img src="__IMG__"></a>
            <a href="/web/index?pid='.$ty.'&ty=@$id@" class="txt">
                <h3>@$catname@</h3>
                <p style="height: 50px;">@$description@<em>更多</em></em></p>
            </a>
        </li>
        ') !!}
    </ul>
</div>
@stop

