@extends('layouts.master')
@section('wapper')
<div class="ny-content clr">
    <div class="content_wrap">
        <div class="ny-nav fl">
            <div class="title">
                <span>{{$pid_catname}}</span>
                <em>{{$pid_catname2}}</em>
            </div>
            <ul>
                {!! $daohang->erji_nav() !!}
            </ul>
            <div class="left-contact" style="min-height: 285px;">
                <div class="top"><span>联系我们</span></div>
                <img src="/style/images/lxwm.jpg">
                <div class="xinxi">
                    <p>
                        <b>公司地址：</b><?=$system_address?>
                    </p>
                    <p>
                        <b>热线电话：</b><?=$system_tel?>
                    </p>
                    <p>
                        <b>传      真：</b><?=$system_fax?>
                    </p>
                    <p>
                        <b>邮      箱：</b><?=$system_email?>
                    </p>
                </div>
            </div>
        </div>
        <div class="ny-right contact-right fr">
            <div class="bread clr">
                <div class="title fl">{{$ty_catname}}</div>
                <div class="location fr">
                    {!! pc_bread() !!}
                </div>
            </div>
            @yield('right')
        </div>
    </div>
</div>
@stop