<div class="footer">
    <div class="server wrap fn-clear">
        <dl>
            <dt class="you"></dt>
            <dd class="t">正品保障</dd>
            <dd>100%正品</dd>
        </dl>
        <div class="line"></div>
        <dl>
            <dt class="xin"></dt>
            <dd class="t">无忧购物</dd>
            <dd>7天无理由退货</dd>
        </dl>
        <div class="line"></div>
        <dl>
            <dt class="hui"></dt>
            <dd class="t">零单批发</dd>
            <dd>无采购限制</dd>
        </dl>
        <div class="line"></div>
        <dl>
            <dt class="bian"></dt>
            <dd class="t">在线支付</dd>
            <dd>银联支付宝</dd>
        </dl>
    </div>
    <div class="bot_box">
        <ul>
            <li>
                <p>关于我们</p>
                <a data-href="about_01.jsp" class="company">公司简介</a>
                <a data-href="contact.jsp" class="contact">联系我们</a>
            </li>
            <li>
                <p>购物指南</p>
                <a data-href="buy.jsp" class="buyProcess">购物流程</a>
            </li>
            <li>
                <p>配送方式</p>
                <a data-href="kuaidi.jsp" class="hzkd">合作快递</a>
                <a data-href="question.jsp" class="pscjwt">配送常见问题</a>
            </li>
            <li>
                <p>支付方式</p>
                <a data-href="fahuo.jsp" class="kdfh">在线支付</a>
                <a data-href="pay.jsp" class="hdfk">按合同发货</a>
                <a data-href="fapiao.jsp" class="syfp">索要发票</a>
            </li>
            <li>
                <p>售后服务</p>
                <a data-href="contact.jsp" class="thhlc">联系我们</a>
            </li>
            <li>
                <p>用户说明</p>
                <a data-href="member_01.jsp" class="qyzc">企业注册</a>
            </li>
            <li>
                <p>帮助</p>
                <a data-href="help.jsp" class="kfzx">客服中心</a>
                <a data-href="statement.jsp" class="mzsm">免责申明</a>
                <a data-href="advice.jsp" class="tsyjy">投诉与建议</a>
            </li>
        </ul>
        <div class="img">
            <p>微信公众号</p>
            <img src="/style/images/code.png">
        </div>
    </div>
    <div class="info">
        找眼镜网 @2013-2018 南京起舵电子商务有限公司版权所有 苏ICP备 16001801号
    </div>
</div>
<!-- 右侧导航 -->
<div class="sideNav">
    <?php if($person->isLogin()): ?>
    <a href="/user/order" class=""><p>我的订单</p><i></i></a>
    <a href="user/cart" class=""><p>购物车</p><i class="gwc"></i></a>
    <a href="javascript:;" class="muOrderBt"><p>我的订单</p><i></i></a>
    <a href="javascript:;" class="cartBt"><p>购物车</p><i class="gwc"></i></a>
    <?php else: ?>
    <?php endif; ?>
    <a href="#"><p class="code"><img src="/style/images/smallAC.png" alt=""></p><i class="ewm"></i></a>
    <style>
        .sideNav a p.code{ height:93px; background: none}
        .sideNav a p.code img{width:100%;}
    </style>
    <a href="http://wpa.qq.com/msgrd?v=3&uin=2987105596&site=qq&menu=yes" target="_blank"><img style="display:none" border="0" src="http://wpa.qq.com/pa?p=2:2987105596:41" alt="点击这里给我发消息" title="点击这里给我发消息"><p>客服</p><i class="qqkf"></i></a>

    <a href="javascript:;"><p>回到顶部</p><i class="toTop"></i></a>
</div>