@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="/style/css/base.css">
    <link rel="stylesheet" href="/style/css/perfect-scrollbar.css">
    <link href="/style/css/pingpai_style.css" rel="stylesheet" type="text/css">
    <link href="/style/css/home_top.css" type="text/css" rel="stylesheet">
    <link href="/style/css/menu.css" type="text/css" rel="stylesheet">
    <link href="/style/css/activell.css" type="text/css" rel="stylesheet">
    <script src="/style/js/jquery.min.js"></script>
    <script src="/style/js/jquery.mousewheel.js"></script>
    <script src="/style/js/perfect-scrollbar.js"></script>
@stop
@section('wapper')

<div class="main"><!--大DIV开始-->
    <div class="left">
        <div style=" text-align:center;font-size:20px; color:#3a76b9;font-weight:bold; line-height:66px">按品牌查找</div>
        <div style="border:1px solid #3a76b9;"></div>
        <div class="box">
            <ul>
            </ul>
        </div>
    </div>

    <div class="right">
        <span style="font-size:20px; color:#3a76b9;font-weight:bold;text-align:left; line-height:66px"
              class="glassForeign">国际品牌</span>
        <div style="border:1px solid #3a76b9;"></div>
        <ul style="" class="internal fn-clear">


            <div class="clear"></div>
        </ul>

        <span style=" margin-top:30px;font-size:20px; color:#3a76b9;font-weight:bold;text-align:left; line-height:66px"
              class="glassgongchang">工厂直供</span>
        <div style="border:1px solid #3a76b9;"></div>
        <ul style="" class="gongchang fn-clear">

            <div class="clear"></div>
        </ul>

        <span style=" margin-top:30px;font-size:20px; color:#3a76b9;font-weight:bold;text-align:left; line-height:66px"
              class="glassInland">国内知名品牌</span>
        <div style="border:1px solid #3a76b9;"></div>
        <ul style="" class="domestic fn-clear">

            <div class="clear"></div>
        </ul>
        <div class="addBlock">
            <span style=" margin-top:30px;font-size:20px; color:#3a76b9;font-weight:bold;text-align:left; line-height:66px"
                  class="glassyouzhi">国内优质品牌</span>
            <div style="border:1px solid #3a76b9;"></div>
            <ul style="" class="youzhi fn-clear">

                <div class="clear"></div>
            </ul>


        </div>
    </div>
    <div class="clear"></div>
</div><!--大DIV结束-->
@stop

@section('scripts')

<script src="/style/js/main.js"></script>
<script>
    var proDetailV = false;
</script>
<script src="/style/js/product.js"></script>
<script src="/style/js/public_bak.js"></script>
<script src="/style/js/login.js"></script>
<div style="display:none">
    <script src="/style/js/z_stat.js" language="JavaScript"></script>
</div>
<script src="/style/js/allsearch.js"></script>
<script>
    jQuery(document).ready(function ($) {
        "use strict";
        $('.main .left .box').perfectScrollbar();
    });
    $(".bot_box li a").click(function () {
        var t = $(this), href = t.attr("href");
        window.open(domain + "/" + href)
    })
</script>
    @stop

    </body>
</html>
