@extends('layouts.master')@section('head')    <meta charset="UTF-8">    <meta name="renderer" content="webkit">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <title> {{$system_seotitle}}</title>    <meta name="keywords" content="{{$system_keywords}}">    <meta name="description" content="{{$system_description}}">    <link href="/style/css/consultation_style.css"  rel="stylesheet" type="text/css" />@stop@section('wapper')    <body>    <!--资讯头部-->    <div class="zixun_box">        <div class="zixun">            <img src="{{$system_logo1}}" />            <ul>                <li><a href="/" target="_blank">首页</a></li>                <?php $cca=v_list('news_cats','id,catname',array('pid'=>1));foreach ($cca as $vc){                    if($ty==$vc['id']){$asd=' class="zixun_dangqian"';}else{$asd='';}                    echo '<li '.$asd.'><a href="/web/index?pid=1&ty='.$vc['id'].'" target="_blank">'.$vc['catname'].'</a></li>';                }?>                <div class="clear"></div>            </ul>        </div>    </div>    <!--资讯内容-->    <div class="info_box">        <div class="info_left">            <div class="big_content">                <a class="topImgSrc" target="_blank"><img src="" class="pic-image"/></a>                <Div class="big_content_font">                    <a class="big_contentA" target="_blank"></a>                    <p></p>                </Div>            </div>            <ul>                @foreach($data as $key=>$val)                <li>                    <div class="xiao_content_left">                        <img src="{{src($val['img'])}}" class=" pic-image"/>                    </div>                    <div class="xiao_content_right">                        <a>{{$val['title']}}</a>                        <p>{{date('Y-m-d',$val['sendtime'])}}</p>                    </div>                    <div class="clear"></div>                </li>                @endforeach            </ul>            <!--加载更多-->            <div class="get_mod_more" data-page="0" data-pid="{{$pid}}" data-ty="{{$ty}}">                点击加载更多            </div>        </div>        <div class="info_right">            <div class="topic-title">                <h2 class="pull-left">热门观点</h2>                <a class="pull-right">更多</a>                <div class="clear"></div>            </div>            <ul>            </ul>        </div>    </div>    </body>@stop@section('scripts')    <script src="/style/js/jquery.min.js"></script>    <script src="/style/js/main.js"></script>    <div style="display:none">        <script src="/style/js/z_stat.js" language="JavaScript"></script>    </div>    <script src="/style/js/message.js"></script>@stop