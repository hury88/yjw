@extends('layouts.master')
@section('css')
<script src="/style/js/jquery-1.9.0.js"></script>
<script type="text/javascript" src="/style/js/jquery.blockui.js"></script>
@stop
@section('wapper')

    <!-- 面包屑 -->
    <div class="bread wrap">
        <a href="index.html">首页</a>><a href="#">镜片</a>><a href="#">品牌</a>><a href="#">目录表</a>
    </div>

    <!-- 内容部分 -->
    <div class="content wrap fn-clear">
        <!-- 左边 -->
        <div class="fn-left left">
            <div class="box" id="box">
            </div>
        </div>
        <!-- 右边 -->
        <div class="fn-right right">
            <div class="title">
                <a href="#">
                    <img src="/style/images/default.png" alt="">
                </a>
            </div>
            <div class="fahuofang fn-clear" style="font-size:14px;">
                <p class="name"><span>发货方：</span>由以下省份发货</p>
                <p><span>南部仓</span>：广西、贵州、广东、福建、海南</p>
                <p><span>中部仓</span>：陕西、重庆、河南、湖北、湖南</p>
                <p><span>东部仓</span>：上海、江苏、浙江、安徽、山东、江西</p>
                <p><span>西部仓</span>：新疆、西藏、青海、甘肃、四川、云南</p>
                <p><span>北部仓</span>：宁夏、内蒙、北京、天津、河北、山西、辽宁、吉林、黑龙江</p>
            </div>
            <div class="ppCon">
                品牌<span></span>
            </div>
            <div class="calssify calssify2 fn-clear"><span class="xx">品种</span>
                <div class="jj_options" data-type='1'>
                </div>
            </div>
            <div class="calssify calssify1 fn-clear"><span class="xx">品种</span>
                <div class="jj_options" data-type='1'>
                </div>
                <div class="jj_info">
                    <table width="100%" border=1 bordercolor="#EEEEEE" cellspacing=0 cellpadding=0>
                        <thead>
                        <tr>
                            <th width="20%">发货方</th>
                            <th width="20%">价格</th>
                            <th width="20%">预计发货时间</th>
                            <th width="20%">普通、顺丰</th>
                            <th width="20%">下单支付</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="notice">注释：不同供应商发货可能会产生多次运费</p>
            <!-- 选项 -->
            <div class="select fn-clear">

                <div class="list xinghao">
                    <div class="line">
                        <span class="fn-left">型号</span>
                        <div class="options" data-type="2">
                        </div>
                        <i></i>
                    </div>
                </div>
                <div class="list sehao">
                    <div class="line">
                        <span class="fn-left">色号</span>
                        <div class="options" data-type="3">
                        </div>
                        <i></i>
                    </div>
                </div>
                <div class="box fn-clear">
                    <div class="list list_half jkchicun">
                        <div class="line">
                            <span class="fn-left">镜框尺寸</span>
                            <div class="options" data-type="4">
                            </div>
                            <i></i>
                        </div>
                    </div>
                    <div class="list list_half blchicun">
                        <div class="line">
                            <span class="fn-left">鼻梁尺寸</span>
                            <div class="options" data-type="5">
                            </div>
                            <i></i>
                        </div>
                    </div>
                </div>
                <div class="box fn-clear">
                    <div class="list list_half kuangxing">
                        <div class="line">
                            <span class="fn-left">框型</span>
                            <div class="options" data-type="6">
                            </div>
                            <i></i>
                        </div>
                    </div>
                    <div class="list list_half kuanshi">
                        <div class="line">
                            <span class="fn-left">款式</span>
                            <div class="options" data-type="7">
                            </div>
                            <i></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 筛选条件 -->
            <div class="cond">
                <span class="cond_title fn-left">已选条件</span>
                <div class="con fn-left">
                </div>
                <span class="del fn-right">全部撤销</span>
            </div>
            <div class="filter fn-clear">
                <a href="javascript:;" class="active zonghe">综合排序</a>
                <a href="javascript:;" class="xinpin">新品</a>
                <a href="javascript:;" class="jiage">价格</a>
            </div>
            <ul class="filter_con fn-clear">
            </ul>
            <div class="but"><a href="javascript:;">显示更多</a></div>
        </div>

    </div>

@stop
@section('scripts')

    <script src="/style/js/public_bak.js"></script>
    <script>
        $(".bot_box li a").click(function () {
            var t = $(this), href = t.attr("href");
            window.open(domain + "/" + href)
        })

    </script>



    <script src="/style/js/jquery.fly.min.js"></script>
    <!--[if lte IE 9]>
    <script src="/style/js/requestAnimationFrame.js"></script>
    <![endif]-->
    <script src="/style/js/main.js"></script>
    <script src="/style/js/login.js"></script>
    <script src="/style/js/allSearch.js"></script>
    <script src="/style/js/jjproduct.js"></script>
    @stop