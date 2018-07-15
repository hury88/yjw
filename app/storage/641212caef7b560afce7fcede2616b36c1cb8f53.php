<!-- 头部 -->
<div class="head">
    <!-- 顶部 -->
    <div class="head_box">
        <div class="wrap">
            <div class="fn-left left">
                <span class="fn-left welcome">您好 <?=$system_sitename?>欢迎您！</span>

                <?php if($person->isLogin()): ?>
                <div class="person fn-left haslogin">
                    <a  href="/user/index">
                        <span class="icon"></span>
                        <span class="phone"><?php echo __e($person->name); ?></span>
                    </a>
                    <a style="margin-left:15px " class="loginOut" href="/user/logout">退出</a>
                </div>
                <?php else: ?>
                <div class="person fn-left haslogout">
                    <a class="btn homeRegBt mendianReg">门店注册</a>
                   <a class="btn homeRegBt center">门店登陆</a>
                    
                </div>
                <?php endif; ?>
            </div>
            <?php if($person->isLogin()): ?>
                <div class="fn-right right">
                    <a href="/user/car" class=""><i class="cart"></i><span>购物车</span></a>
                    <a href="/user/car" class=""><i class="order"></i><span>订单</span></a>
                    <a href="/user/index" class=""><i class="personIcon"></i><span>个人中心</span></a>
                </div>
            <?php else: ?>
                <div class="fn-right right">
                    <a class="center"><i class="cart"></i><span>购物车</span></a>
                    <a class="center"><i class="order"></i><span>订单</span></a>
                    <a class="center"><i class="personIcon"></i><span>个人中心</span></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- logo部分 -->
    <div class="head_logo">
        <div class="wrap fn-clear">
            <div class="fn-left logo">
                <a href="#">
                    <img src="/style/images/logo.png" alt="">
                </a>
            </div>
            <div class="loginBox fn-left">
                    <?php if($person->isLogin()): ?>
                        <!-- <a class="login" href="/user/index">门店中心</a> -->
                    <?php else: ?>
                    <div class="topBlock">
                        <a class="login" href="javascript:;">门店登录</a>

                    </div>
                    <?php endif; ?>
                    <!--<a class="loginSupplier">供应商入驻</a>-->
                <div class="bottomBlock">
                    <p><i class="tel"></i>18013382890（客服电话和微信号）</p>
                    <p><i class="tel"></i>18013382890（客服电话和微信号）</p>
                	<p><i class="tel"></i>18013380871（客服电话和微信号）</p>
                </div>
            </div>
            <div class="search_box fn-left">
                <div class="search fn-clear">
                    <input class="fn-left search_text" type="text" value="请输入商品关键词搜索或商品编号搜索" onfocus="if(value=='请输入商品关键词搜索或商品编号搜索'){value=''}" onblur="if(value==''){value ='请输入商品关键词搜索或商品编号搜索'}">
                    <input type="button" class="fn-left btn">
                </div>
            </div>
            <div class="fn-right erweima">
                <img src="/style/images/smallAC.png" alt="">
            </div>
        </div>
    </div>

    <!-- 导航部分 -->
    <div class="nav">
        <div class="wrap">
            <div class="all_goods active" href="#">全部商品
                <ul class="bannerLeftUl" style="<?php echo __e(IS_INDEX?'height: 490px;':'height: 0;'); ?>">
                    <li data-value="0">
                        <a href="#">
                            <i class="icon01"></i>
                            <span>镜片</span>
                        </a>
                    </li>
                    <li data-value="4">
                        <a href="#">
                            <i class="icon02"></i>
                            <span>镜架</span>
                        </a>
                    </li>
                    <li data-value="7">
                        <a href="#">
                            <i class="icon03"></i>
                            <span>太阳镜</span>
                        </a>
                    </li>
                    <li data-value="6">
                        <a href="#">
                            <i class="icon04"></i>
                            <span>功能眼镜</span>
                        </a>
                    </li>
                    <li data-value="2">
                        <a href="#">
                            <i class="icon05"></i>
                            <span>其他</span>
                        </a>
                    </li>
                </ul>
            </div>
            <a class="nav_btn" href="business.html">找商家</a>
            <a class="nav_btn" href="index-1.html">首页</a>
            <a class="nav_btn" href="message.html">资讯</a>
        </div>
    </div>
<!-- 门店登录 -->
<div class="login_box loginPop" style="display: none">
    <div class="login"> <img class="close" src="/style/images/close.png">
        <h2>账户登录</h2>
        <form class="form" action="/user/login">
        <ul>
            <li>
                <input type="text" class="ipt" placeholder="登录名" value="" name="username" id="account" autocomplete="off">
            </li>
            <li>
                <input type="password" class="ipt" placeholder="密码" value="" name="password" id="pwd" autocomplete="off">
            </li>
            <li>
                <button class="btn loginBt">立即登录</button>
            </li>
        </ul>
        </form>
        <p class="null" style="display: none;">*用户名或者密码不能为空</p>
        <div class="go_register"> <a href="/user/zhuce" target="_blank">免费注册</a>
            <div class="clr"></div>
        </div>
    </div>
</div>
<?php if(IS_INDEX): ?>
<!-- banner轮播 -->
<div class="banner_box slideBox" id="slideBox">
    <div class="hd">
            <ul></ul>
    </div>
    <div class="bd">
        <ul>
        	<li class="pc26" style="background-image: url('http://image.zyanjing.com/hotproduct//20171221090625_镜谱PC端.jpg');"><a href="http://www.zyanjing.com/jjSelect.html?256%4" target="_blank"></a></li>
        </ul>
    </div>
</div>

<!--横排菜单结束-->
<!-- banner轮播结束 -->
<?php else: ?>
  
<?php endif; ?>