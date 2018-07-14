/**
 * Created by lianglong on 16/1/18.
 */
(function(){
    var ckSlideUl = $(".ck-slide-wrapper"),
        commodityLeft = $(".commodity_left"),
        commodityMid = $(".commodity_mid"),
        commodityRight = $(".commodity_right"),
        CZ = $(".CZ"),
        KS = $(".KS"),
        KX = $(".KX"),
        JPLX = $(".JPLX"),
        ZSL = $(".ZSL"),
        GN = $(".GN"),
        informationUl = $(".information ul"),
        marqueeUl = $("#marquee ul"),
        account = $('#account'),
        pwd = $('#pwd'),
        loginBt = $(".loginBt"),
        loginPop = $(".loginPop"),
        loginA = $(".loginA"),
        body = $("body"),
        loginCont = $(".loginCont"),
        signin = $(".signin"),
        topHasLogin = $(".topHasLogin"),
        logOut = null,
        signout = $(".signout"),
        dropdown = $(".dropdown"),
        dropdownCont = $(".dropdownCont"),
        frameSearchBt = $(".frameSearchBt"),
        CZValue = $(".CZValue"),
        KSValue = $(".KSValue"),
        KXValue = $(".KXValue"),
        JPLXValue = $(".JPLXValue"),
        sunSearchBt = $(".sunSearchBt"),
        bannerLeftUlLi = $(".bannerLeftUl li"),
        GN_searchBt = $(".GN_searchBt"),
        tanceng = $(".tanceng"),
        guoji = $(".guoji"),
        guonei = $(".guonei"),
        chongzhi_btm = $(".chongzhi_btm"),
        recharge = $("#recharge"),
        chongzhi = $(".chongzhi"),
        fastMoney = $(".fastMoney");

    var commodityLeftArray = [],
        commodityMidArray = [],
        commodityRightArray = [],
        rechargeMoney = "";

    var ajaxArray = [];


    var timeT = 60000;

    var beginUrl = null;//左侧快捷导航

    $(document).ready(function(){

        var loginName = getCookie("account");
        var loginPwd = getCookie("pwd");

        var loginAccount = loginName,
            loginPWD = loginPwd;

        var bannerNumber = 0;

        var cookieTime= new Date();
        cookieTime.setHours(cookieTime.getHours() + 24);
	/*
        setTimeout(function(){
            if(loginAccount){
                login();
            }
        },0);
	*/

        commodityLeft.each(function(){
            commodityLeftArray.push($(this));
        });

        commodityMid.each(function(){
            commodityMidArray.push($(this));
        });

        commodityRight.each(function(){
            commodityRightArray.push($(this));
        });


        ajaxArray[0] = $.ajax({
            type:"GET",
            url:""+domain+"/hot_product!getHotProductList.shtml",
            dataType:"json",
            contentType : "text/plain; charset=utf-8",
            cache:false,
            xhrFields:{
                withCredentials: true
            },
            timeout : timeT,
            success:function(data){
                var obj = data.hot_product_list;

                var homeHotN = 0,
                    commodityMidN = 0,
                    commodityMidAppendN = 0,
                    commodityRightN = 0;
                for(var i=0;i<obj.length;i++){
                    switch(parseInt(obj[i].type)){
                        case 0:
                            var price = obj[i].price;
                            if(price == '价格登录可见' || price == defaultString)
                                priceClass = "fontSmall";
                            else
                                priceClass = "";

                            commodityMidArray[commodityMidN].append('<div class="shop_box">'+
                                '<a href='+obj[i].link+' target="_blank">'+
                                '<div class="tu_box"><img src='+obj[i].image+'></div>'+
                                '<div class="txtj" style="" ><center><p>特价</p>' +
                                '<span class="cantSee '+ priceClass+ '" style="color: red;line-height: 17px;" >'+price+'</span></center></div>'+
                                '<div class="commodityRightp"><center><span>'+obj[i].name+'</span><span>'+obj[i].model+'</span></center></div>'+
                                '</a></div>');
                            commodityMidAppendN++;
                            if(commodityMidAppendN==6){
                                commodityMidN++;
                            }
                            break;
                        case 1:
                            commodityLeftArray[homeHotN].find("img").attr('src',obj[i].image);
                            homeHotN++;
                            break;
                        case 2:
                            if(obj[i].status == 1){
                                    $("#slideBox .hd ul").append('<li></li>');
                                    $("#slideBox .bd ul").append('<li class="pc'+i+'"><a href="'+data.hot_product_list[i].link+'" target="_blank"></a></li>');
                                    $("li.pc"+i+"").css("backgroundImage","url("+data.hot_product_list[i].image+")");
                              
                                jQuery(".slideBox").slide({mainCell:".bd ul",autoPlay:true,pnLoop:false});
                            }

                            break;
                        case 3:
                            var price = obj[i].price;
                            if(price == '价格登录可见' || price == defaultString)
                                priceClass = "fontSmall";
                            else
                                priceClass = "";

                            commodityRightArray[commodityRightN].append(
                                '<a href='+obj[i].link+' class="commodityRightA" target="_blank">'+
                                '<img src='+obj[i].image+'>'+
                                '<div class="txtj" style="width: 80%;margin-left: 20%;" ><center><p>特价</p>'+
                                '<span class="cantSee ' + priceClass + '" style="color: red;line-height: 17px;" data-Joudee='+obj[i].price+'>'+obj[i].price+'</span></center></div>'+
                                '<div class="commodityRightp"><center><span>'+obj[i].name+'</span><span>'+obj[i].model+'</span></center></div>'+
                                '</a>');
                            commodityRightN++;
                            break;
                    }
                }



                if(custId==null||custId=="null"){
                    $(".cantSee").css("color","red");
                }else 
                {
                	if(custParent != null && custParent !="null")
                	{
                		$(".cantSee").css("color","red");
                	}
                	else
                	{
                		$(".cantSee").append('元');
                	}
                }               

                var commodityRightp = $(".commodityRightp");
                commodityRightp.find("span").each(function(){
                    if($(this).html()=="undefined"){
                        $(this).html("");
                    }
                });
                $('body').append('<script type="text/javascript" src="js/slide.js"></script>');
                $('.ck-slide').ckSlide({
                    autoPlay: true
                });


            },
            error:function(){
                console.log("链接失败");
            }
        });

        /**行业咨询**/
        ajaxArray[1] = $.ajax({
            type:"POST",
            url:"http://www.zyanjing.com/zyanjing_service/service.do?key=getCache",
            data:'{"body":{"keys":"XG_INFO_MAIN_PAGE"}}',
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            timeout : timeT,
            success:function(data){
                var obj = data.body.data.XG_INFO_MAIN_PAGE.list;
                for(var i=0;i<7;i++){
                    informationUl.append('<li><img src="images/info_icon.png"><a href="mesdetail.html?'+obj[i].info_id+'&message" target="_blank">'+obj[i].title+'</a><div class="clear"></div></li>');
                }
            },
            error:function(){
                console.log("链接失败");
            }
        });


        /**市场动态**/
        ajaxArray[2] = $.ajax({
            type:"POST",
            url:"http://www.zyanjing.com/zyanjing_service/service.do?key=QueryOrder",
            data:'{"body":{"keys":"XG_ORDER_DATA"}}',
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            timeout : timeT,
            success:function(data){
                
                var obj = data.body.data.list;
                var proIdArray = [],
                    proId = null;
                for(var i=0;i<obj.length;i++){
                    proIdArray = obj[i].prod_url.toString().split("=");
                    proId = proIdArray[1];
                    marqueeUl.append('<li><a href="'+obj[i].prod_url+'" target="_blank"><i>' + obj[i].prodName + '</i><em>' + obj[i].prodAmount + '件</em><span>成交</span></a></li>');
                }



                var scrollD = 0;

                var scrollT = setInterval(mar,50);



                function mar(){
                    scrollD++;
                    $('#marquee').scrollTop(scrollD);
                    if(($('#marquee').height()+$('#marquee').scrollTop())==($('#marquee ul').height())){
                        clearInterval(scrollT);
                        for(var i=0;i<obj.length;i++){
                            proIdArray = obj[i].prod_url.toString().split("=");
                            proId = proIdArray[1];
                            marqueeUl.append('<li><a href="productDetail.html?'+proId+'" target="_blank"><i>' + obj[i].prodName + '</i><em>' + obj[i].prodAmount + '件</em><span>成交</span></a></li>');
                        }
                        scrollT = setInterval(mar,50);
                    }
                }

                $('#marquee').mouseenter(function(){
                    clearInterval(scrollT);
                }).mouseleave(function(){
                    scrollT = setInterval(mar,50);
                });


            },
            error:function(){
                console.log("链接失败");
            }
        });



        dropdown.each(function(){
            $(this).click(function(){
                dropdown.css({
                    "overflow":"hidden",
                    "z-index":"0"
                });
                if($(this).hasClass("hasClick")){
                    $(this).css({
                        "overflow":"hidden",
                        "z-index":"0"
                    });
                    $(this).removeClass("hasClick");
                }else {
                    $(this).css({
                        "overflow":"visible",
                        "z-index":"1001"
                    });
                    dropdown.removeClass("hasClick");
                    $(this).addClass("hasClick");
                }

                return false;
            });
        });


        /**下拉框选值**/
        function dropdownContClick(){
            dropdownCont.find("p").click(function(){
                $(this).parent().parent().find("span").html($(this).html());
                $(this).parent().parent().attr("data-value",$(this).attr("data-value"));
            });
        }



        /**镜架搜索**/
        frameSearchBt.click(function(){
            window.open("productListBig.html?"+$(this).parent().find(".CZValue").attr('data-value')+"&"+$(this).parent().find(".KSValue").attr('data-value')+"&"+$(this).parent().find(".KXValue").attr('data-value')+"");
        });
        /**END镜架搜索**/

        sunSearchBt.click(function(){
            window.open("productListBig.html?"+$(this).parent().find(".CZValue").attr('data-value')+"&"+$(this).parent().find(".KSValue").attr('data-value')+"&"+$(this).parent().find(".KXValue").attr('data-value')+"&"+$(this).parent().find(".JPLXValue").attr('data-value')+"");
        });

        GN_searchBt.click(function(){
            window.open("lens.html?"+$(this).parent().find(".ZSL_value").find("span").html()+"&"+$(this).parent().find(".GN_value").attr('data-value'));
        });

        bannerLeftUlLi.click(function(){
            window.open("eyeglass.html?"+$(this).attr("data-value"));
        });


        var type_value = 0;
        var hasAddN = 0,
            brDom = "",
            glassName = "";
        function homeLeft(){
            $.ajax({//获取首页轮播左侧导航
                type: "POST",
                url: domain + "/company_brand!getCompanyBrand.shtml?type_value="+type_value,
                dataType: 'json',
                contentType: "text/plain; charset=utf-8",
                timeout : timeT,
                success: function (data) {
                    guoji.find(".pingpai_box").empty();
                    guonei.find(".pingpai_box").empty();
                    hasAddN= 0 ;
                    for(var i=0;i<data.international_1_list.length;i++){//国际
                        guoji.find(".pingpai_box").append('<div class="allBrandName"><h2>'+data.international_1_list[i].name+'：</h2>'+
                            '<div class="pingpai pingpai'+i+'"></div>'+
                            '<Div class="clear"></Div></div>');
                        var pClass = ".pingpai"+i;
                        for(var j=0;j<data.international_1_list[i].company_brand_list.length;j++){

                            if(hasAddN==4){
                                brDom = "";
                            }else {
                                brDom = "";
                            }
                            if(data.international_1_list[i].company_brand_list[j].type_value==0) {
                                glassName = "=" + data.international_1_list[i].company_brand_list[j].brand_name;
                            }else {
                                glassName = "";
                            }
                            $(""+pClass+"").append('<a href='+beginUrl+''+data.international_1_list[i].company_brand_list[j].brand_value+''+gType+''+glassName+' target="_blank">'+data.international_1_list[i].company_brand_list[j].brand_name+'</a>'+brDom+'');
                            hasAddN++;
                        }

                    }
                    guoji.find(".pingpai_box").append("<a  target='_blank' style='display:block; position:absolute; right:20px; bottom:10px; cursor:pointer; font-size:14px; color:#7D9CFF;' href='eyeglass.html?"+data.international_1_list[0].company_brand_list[0].type_value+"'>更多&gt;&gt;</a>");
                    //for(var s=0;s<data.international_0_list.length;s++){//国内
                    //    guonei.find(".pingpai_box").append('<div class="allBrandName"><h2>'+data.international_0_list[s].name+'：</h2>'+
                    //        '<div class="pingpai pingpai'+s+'"></div>'+
                    //        '<Div class="clear"></Div></div>');
                    //    var pClasss = ".pingpai"+s;
                    //    for(var p=0;p<data.international_0_list[s].company_brand_list.length;p++){
                    //        $(""+pClasss+"").append('<a href='+beginUrl+''+data.international_0_list[s].company_brand_list[p].brand_value+''+gType+'>'+data.international_0_list[s].company_brand_list[p].brand_name+'</a>| ');
                    //    }
                    //}

                    $(".pingpai").each(function(){
                       if($(this).html()==""){
                           $(this).parent().hide();
                       }
                    });
                }
            });
        }

        var gType = "";

        bannerLeftUlLi.mouseenter(function(){
            type_value = $(this).attr("data-value");
            switch (parseInt(type_value)){
                case 0:
                    beginUrl = "lens.html?";
                    gType = "";
                    break;
                case 4:
                    beginUrl = "productListBig.html?";
                    gType = "%4";
                    break;
                case 7:
                    beginUrl = "productListBig.html?";
                    gType = "%7";
                    break;
                case 6:
                    beginUrl = "productListBig.html?";
                    gType = "%6";
                    break;
                case 2:
                    beginUrl = "productListBig.html?";
                    gType = "%2";
                    break;
            }
            homeLeft();
        });




    });




    $(".login").click(function(){
       return false;
    });

    $(".close").click(function(){
        loginPop.fadeOut();
        return false;
    });

    //$(".registerBt").click(function(){
    //    window.open(domain+"/shopRegister.jsp");
    //});


    //$(".company").click(function(){//公司简介
    //    window.open(domain+"/about_01.jsp");
    //});
    //$(".contact").click(function(){//联系我们
    //    window.open(domain+"/contact.jsp");
    //});
    //$(".buyProcess").click(function(){//购物流程
    //    window.open(domain+"/buy.jsp");
    //});
    //$(".hzkd").click(function(){//合作快递
    //    window.open(domain+"/kuaidi.jsp");
    //});
    //$(".pscjwt").click(function(){//配送常见问题
    //    window.open(domain+"/question.jsp");
    //});
    //$(".kdfh").click(function(){//款到发货
    //    window.open(domain+"/fahuo.jsp");
    //});
    //$(".hdfk").click(function(){//货到付款
    //    window.open(domain+"/pay.jsp");
    //});
    //$(".syfp").click(function(){//索要发票
    //    window.open(domain+"/fapiao.jsp");
    //});
    //$(".thhlc").click(function(){//退换货流程
    //    window.open(domain+"/service_02.jsp");
    //});
    //$(".qyzc").click(function(){//企业注册
    //    window.open(domain+"/member_01.jsp");
    //});
    //$(".kfzx").click(function(){//客服中心
    //    window.open(domain+"/help.jsp");
    //});
    //$(".mzsm").click(function(){//免责申明
    //    window.open(domain+"/statement.jsp");
    //});
    //$(".tsyjy").click(function(){//投诉与建议
    //    window.open(domain+"/advice.jsp");
    //});



    //点击充值
    chongzhi_btm.click(function(){
        if(recharge.val()) {
            rechargeMoney = recharge.val();
        }else {
            rechargeMoney = "";
        }

        if(custId=="null"||custId==null){
            loginPop.fadeIn();
        }else {
            window.open(domain+"/pay_confirm.jsp?recharge_val="+rechargeMoney);
        }
        return false;
    });

    //整数金额充值
    chongzhi.find("li").click(function(){

        if(custId=="null"||custId==null) {
            loginPop.fadeIn();

        }else {
            rechargeMoney = $(this).find("b").html();
            if(rechargeMoney=="充值"){ rechargeMoney = recharge.val();}
            chongzhi.find("li").find("a").removeClass("chong_xuan");
            $(this).find("a").addClass("chong_xuan");
            recharge.val("");
            window.open(domain + "/pay_confirm.jsp?recharge_val=" + rechargeMoney);

        }
        return false;
    });



    //只可以输入数字和小数点,保留小数点后两位
    var hasPoint = false,
        decimalN = 0;

    recharge.keydown(function(event){
        chongzhi.find("li").find("a").removeClass("chong_xuan");
        var keyCode = event.keyCode;

        console.log(keyCode);
        if(keyCode >= 48 && keyCode <= 57&&decimalN<3){
            console.log("数字");
        }else if(keyCode==190&&!hasPoint&&$(this).val()!=""||keyCode==110){
            console.log("小数点");
        }else if(keyCode==8){
            console.log("删除");
            if(decimalN>0){
                decimalN--;
            }

        }else if(keyCode >= 96 && keyCode <= 105&&decimalN<3){
console.log("数字");
	}
	else {
            return false;
        }

        if(keyCode==190||keyCode==110){
            hasPoint = true;
        }
        if(hasPoint&&decimalN<3&&keyCode!=8){
            decimalN++;
        }
        if(decimalN==0){
            hasPoint = false;
        }
    });

    body.click(function(){
        dropdown.css("overflow","hidden");
        dropdown.removeClass("hasClick");
    });

    window.onbeforeunload = function(){
        for(var i=0;i<ajaxArray.length;i++){
            ajaxArray[i].abort();
        }
    }

     


    // 导航
    $(".nav .all_goods li").hover(function(){
        var t = $(this);
        t.addClass("hei").siblings("li").removeClass("hei");
    })
    

    // 顶部
    $("span.triangle").hover(function(){
        var t = $(this);
        t.addClass("on");
    },function(){
        var t = $(this);
        t.removeClass("on");
    })

    // 回到顶部
    $(".toTop").click(function(){
        $('body,html').animate({scrollTop:0},1000); 
    })


    // 底部链接
    $(".bot_box li a").click(function(){
        var t = $(this), href = t.attr("data-href");
        window.open(domain+"/"+href)
    })
}());

