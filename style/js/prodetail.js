/**
 * Created by lianglong on 16/1/25.
 */
var proName = null,
    imgSrc = null,
    thisPrice = 0;
(function(){
    var bigImg = $("#midimg"),
        imageMenuUl = $("#imageMenu ul"),
        chanpintu = $(".chanpintu"),
        describe = $(".describe"),
        canshuUl = $(".canshu ul"),
        buyNowBt = $(".buyNowBt"),
        addCar = $(".addCar"),
        photometricBt = $(".photometricBt"),
        addBt = $("i.addBt"),
        reduceBt = $("i.reduceBt"),
        orderNum = $("#num");
        plus= $('.plus');

var json = changeJson();
    var prod_id = json.prod_id,   //商品id
        discount = json.discount,  //商品折扣
        sku_id = json.sku_id,
        supplier_id = json.supplier_id; //提供商

         addBt.click(function(){

            orderNum.val(parseInt(orderNum.val())+1);

        });

        reduceBt.click(function(){
            if(parseInt(orderNum.val())>1){
                orderNum.val(parseInt(orderNum.val())-1);
            }
        });

    $.ajax({
        type:"GET",
        url:domain+"/detail_product!getProductDetail.shtml?prodId="+prod_id,
        dataType : 'json',
        contentType : "text/plain; charset=utf-8",
        cache:false,
        xhrFields:{
            withCredentials: true
        },
        success:function(data){
            var prodType = data.prod_type,
                marketPrice = data.market_price,
                custPrice = data.cust_price,
                prodId = prod_id,
                isFix = data.isfix;
                lens_type = data.lens_type;
			if(marketPrice == '价格登录可见')
			{
				
			}
			else
			{
				if(marketPrice == defaultString)
				{
					
				}
				else
				{
					marketPrice =  parseFloat(marketPrice*discount/100).toFixed(2);
				}
				
			}
            switch (parseInt(data.prod_type)){
                case 4:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>产地：<span>'+data.prod_field+'</span></p>'+
                        '<p>材质：<span>'+data.prod_material+'</span></p>'+
                        '<p>框型：<span>'+data.prod_shape+'</span></p>'+
                        '<p>款式：<span>'+data.prod_style+'</span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');


                    canshuUl.append('<li><p>镜面宽度：<span>'+data.mirr_width+'</span></p></li>'+
                        '<li><p>鼻梁宽度：<span>'+data.nose_width+'</span></p></li>'+
                        '<li><p>镜框高度：<span>'+data.frame_width+'</span></p></li>'+
                        '<li><p>镜腿长度：<span>'+data.tem_width+'</span></p></li>'+
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>型号：<span>'+data.version+'</span></p></li>'+
                        '<li><p>材质：<span>'+data.prod_material+'</span></p></li>'+
                        '<li><p>色系：<span>'+data.color_sys+'</span></p></li>'+
                        '<li><p>框型：<span>'+data.prod_shape+'</span></p></li>'+
                        '<li><p>款式：<span>'+data.prod_style+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<div class="clear"></div>');
                    buyNowBt.show();
                    addCar.show();
                     plus.show();
                    photometricBt.hide();
                   
                    
                    break;

                case 6:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>产地：<span>'+data.prod_field+'</span></p>'+
                        '<p>材质：<span>'+data.prod_material+'</span></p>'+
                        '<p>框型：<span>'+data.prod_shape+'</span></p>'+
                        '<p>款式：<span>'+data.prod_style+'</span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');


                    canshuUl.append('<li><p>镜面宽度：<span>'+data.mirr_width+'</span></p></li>'+
                        '<li><p>鼻梁宽度：<span>'+data.nose_width+'</span></p></li>'+
                        '<li><p>镜框高度：<span>'+data.frame_width+'</span></p></li>'+
                        '<li><p>镜腿长度：<span>'+data.tem_width+'</span></p></li>'+
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>型号：<span>'+data.version+'</span></p></li>'+
                        '<li><p>材质：<span>'+data.prod_material+'</span></p></li>'+
                        '<li><p>色系：<span>'+data.color_sys+'</span></p></li>'+
                        '<li><p>框型：<span>'+data.prod_shape+'</span></p></li>'+
                        '<li><p>款式：<span>'+data.prod_style+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<div class="clear"></div>');

                    buyNowBt.hide();
                    addCar.hide();
                     plus.hide();
                    photometricBt.show();

                    break;

                case 7:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>产地：<span>'+data.prod_field+'</span></p>'+
                        '<p>材质：<span>'+data.prod_material+'</span></p>'+
                        '<p>框型：<span>'+data.prod_shape+'</span></p>'+
                        '<p>款式：<span>'+data.prod_style+'</span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');


                    canshuUl.append('<li><p>镜面宽度：<span>'+data.mirr_width+'</span></p></li>'+
                        '<li><p>鼻梁宽度：<span>'+data.nose_width+'</span></p></li>'+
                        '<li><p>镜框高度：<span>'+data.frame_width+'</span></p></li>'+
                        '<li><p>镜腿长度：<span>'+data.tem_width+'</span></p></li>'+
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>型号：<span>'+data.version+'</span></p></li>'+
                        '<li><p>材质：<span>'+data.prod_material+'</span></p></li>'+
                        '<li><p>色系：<span>'+data.color_sys+'</span></p></li>'+
                        '<li><p>框型：<span>'+data.prod_shape+'</span></p></li>'+
                        '<li><p>款式：<span>'+data.prod_style+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<div class="clear"></div>');
                    buyNowBt.show();
                    addCar.show();
                    photometricBt.hide();
                    plus.show();
                    break;

                case 2:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>材质：<span>'+data.prod_material+'</span></p>'+
                        '<p>系列：<span>'+data.prod_series+'</span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');

                    canshuUl.append(
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>型号：<span>'+data.version+'</span></p></li>'+
                        '<li><p>材质：<span>'+data.prod_material+'</span></p></li>'+
                        '<li><p>系列：<span>'+data.prod_series+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<div class="clear"></div>');
                    buyNowBt.show();
                    addCar.show();
                     plus.show();
                    photometricBt.hide();
                    break;

                case 5:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>产地：<span>'+data.prod_field+'</span></p>'+
                        '<p>系列：<span>'+data.prod_series+'</span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');

                    canshuUl.append(
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>型号：<span>'+data.version+'</span></p></li>'+
                        '<li><p>系列：<span>'+data.prod_series+'</span></p></li>'+
                        '<li><p>容量：<span>'+data.volume+'</span></p></li>'+
                        '<div class="clear"></div>');
                    buyNowBt.show();
                    addCar.show();
                    photometricBt.hide();
                    plus.show();
                    break;

                case 0:

                    if(data.imgs_path[0].img_path==""||data.imgs_path[0].img_path=="undefined"||data.imgs_path[0].img_path==undefined){
                        $(".bigImg img").attr("src","images/glassStatic.jpg");
                    }

                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>系列：<span>'+data.prod_series+'</span></p>'+
                        '<p>类型：<span>'+data.lens_type+'</span></p>'+
                        '<p>品种：<span>'+data.breed+'</span></p>'+
                        '<p>定制片：<span></span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');


                    canshuUl.append(
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>系列：<span>'+data.prod_series+'</span></p></li>'+
                        '<li><p>品种：<span>'+data.breed+'</span></p></li>'+
                        '<li><p>类型：<span>'+data.lens_type+'</span></p></li>'+
                        '<li><p>折射率：<span>'+data.lens_refra_index+'</span></p></li>'+
                        '<li><p>透射比：<span>'+data.trans_percent+'</span></p></li>'+
                        '<li><p>直径：<span>'+data.diameter+'</span></p></li>'+
                        '<li><p>中心厚度：<span>'+data.cen_thick+'</span></p></li>'+
                        '<li><p>阿贝系数：<span>'+data.abe_coe+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<div class="clear"></div>');

                    buyNowBt.hide();
                    addCar.hide();
                     plus.hide();
                    photometricBt.show();
                    break;

                case 1:
                    describe.append(' <h1>'+data.prod_name+'</h1>'+
                        '<h2>现价：<span data-joudee='+marketPrice+' class="cantSee">'+marketPrice+'</span></h2>'+
                        '<p>品牌：<span>'+data.prod_brand+'</span></p>'+
                        '<p>系列：<span>'+data.prod_series+'</span></p>'+
                        '<p>变更周期：<span>'+data.var_period+'</span></p>'+
                        '<p>包装：<span></span></p>'+
                        '<p>支付方式：<span>在线支付</span></p>'+
                        '<p>计量单位：<span>'+data.meas_unit+'</span></p>');


                    canshuUl.append(
                        '<li><p>品牌：<span>'+data.prod_brand+'</span></p></li>'+
                        '<li><p>产地：<span>'+data.prod_field+'</span></p></li>'+
                        '<li><p>系列：<span>'+data.prod_series+'</span></p></li>'+
                        '<li><p>变更周期：<span>'+data.var_period+'</span></p></li>'+
                        '<li><p>功能：<span>'+data.lens_fun+'</span></p></li>'+
                        '<li><p>颜色：<span>'+data.prod_color+'</span></p></li>'+
                        '<li><p>含水量：<span>'+data.water_percent+'</span></p></li>'+
                        '<li><p>基弧：<span>'+data.base_bow+'</span></p></li>'+
                        '<li><p>曲率：<span>'+data.lens_curv+'</span></p></li>'+
                        '<li><p>直径：<span>'+data.diameter+'</span></p></li>'+
                        '<li><p>透射比：<span>'+data.trans_percent+'</span></p></li>'+
                        '<li><p>透氧系数：<span>'+data.yy_co+'</span></p></li>'+
                        '<li><p>中心厚度：<span>'+data.cen_thick+'</span></p></li>'+
                        '<li><p>规格：<span>'+data.standard+'</span></p></li>'+
                        '<div class="clear"></div>');

                    buyNowBt.hide();//立即购买按钮
                    addCar.hide();//加入购物车按钮
                     plus.hide();
                    photometricBt.show();//选择光度按钮

                    break;

            }

            describe.find("p").each(function(){
                if($(this).find("span").html()=="undefined"){
                    $(this).find("span").html("");
                }
            });



            if(custId==null||custId=="null"){
                $(".cantSee").css("color","red");
            }else{
                $(".cantSee").css("color","#f19716");
            }



            proName = $(".describe").find("h1").html();
            imgSrc = data.imgs_path[0].img_path;
            thisPrice = data.market_price;

            bigImg.attr("src",data.imgs_path[0].img_path);
            for(var i=0;i<data.imgs_path.length;i++){
                if(data.imgs_path[i].img_path==""||data.imgs_path[i].img_path=="undefined"||data.imgs_path[i].img_path==undefined) {
                    imageMenuUl.append('<li><img src="images/glassStatic.jpg" width="68" height="68" /></li>');
                }else {
                    imageMenuUl.append('<li><img src=' + data.imgs_path[i].img_path + '  /></li>');
                }
            }
            imageMenuUl.children().first().attr("id","onlickImg");
            chanpintu.empty();
            chanpintu.append(data.prod_content);

            buyNowBt.click(function(){
                if(instantCartInfo(marketPrice,custPrice,prodId,prodType,isFix)){
                    window.open(domain + '/skuCartInfoList.jsp');
                }
                return false;
            });


            addCar.click(function(){

                addCartInfo(marketPrice,custPrice,prodId,prodType,isFix);
                return false;
            });

            photometricBt.click(function(){

                addCartInfo(marketPrice,custPrice,prodId,prodType,isFix);
                return false;
            });

            //点击立即购买的操作
            function instantCartInfo(marketPrice,custPrice,prodId,prodType,isFix){
                var hasBuy = null;
                if(custId == null || custId == ""){

                    loginPop.fadeIn();
                    return false;
                }
                //如果客户的类型是消费者,则取市场价格;否则取批发价

                //依据产品类型去判断,如果是镜架或者太阳眼镜直接加入购物车
                if(prodType == '2' || prodType == '3' || prodType == '4' || prodType == '5' || prodType == '7'){
                    $.ajax({
                        url:domain+'/cart!addCartFromProduct.shtml',
                        type: 'post',
                        data: {"prod_id":prodId,"quantity":$("#num").val(),"flag":1,"supplier_id":supplier_id,"sku_id":sku_id},
                        async: false,
                        xhrFields:{
                            withCredentials: true
                        },
                        timeout: 10000,
                        error: function()
                        {
                            alert('操作失败!');
                        },
                        success: function(data)
                        {
                            if(data != null) {
                                hasBuy = true;
                                console.log(data);
                                return hasBuy;
                            }
                        }
                    });
                }
                return hasBuy;
            }


            //点击加入购物车的操作
            function addCartInfo(marketPrice,custPrice,prodId,prodType,isFix){
                if(custId == null || custId == ""){

                    loginPop.fadeIn();
                    return false;
                }
                //如果客户的类型是消费者,则取市场价格;否则取批发价
                //依据产品类型去判断,如果是镜架或者太阳眼镜直接加入购物车
                if(prodType == '2' || prodType == '3' || prodType == '4' || prodType == '5' || prodType == '7'){
                    $.ajax({
                        url:domain+'/cart!addCartFromProduct.shtml',
                        type: 'post',
                        xhrFields:{
                            withCredentials: true
                        },
                        data: {"prod_id":prodId,"quantity":$("#num").val(),"flag":1,"supplier_id":supplier_id,"sku_id":sku_id},
                        timeout: 10000,
                        error: function()
                        {
                            alert('操作失败!');
                        },
                        success: function(data)
                        {

                            if(data != null)
                                alert('加入购物车成功!');
                        }
                    });
                    return true;
                }

                //如果是镜片或者隐形眼镜
                if(prodType == '0' || prodType == '1' ){
                    var url = '';
                    if(isFix == '1')
                    {
                    	url = prevdomein+'/dingzhi.html?isfix=' + isFix+"&prodType="+prodType+"&prod_id="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&lens_type="+lens_type;
                    	window.open(url);
                    	return false;
                    }
                    else
                    {
                    	if(lens_type == '4')
	                    {
	                    	url = domain+'/cartSkuGradualJpInfo.jsp';
	                    }
	                    else
	                    {
	                    	 url = domain+'/cartSkuJpInfo.jsp';
	                    }
                    }
                 }
                 else if(prodType == '6')
                 {
                 	url = domain+'/cartSkuJpInfo.jsp';
                 }
                    url = url + "?isfix=" + isFix+"&prodType="+prodType+"&prodId="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&lens_type="+lens_type;
                    window.open(url);
            }

            $("body").append('<script src="js/viewHistory.js"></script>'+
                '<script type="text/javascript" src="js/xiangqin.js"></script>');


            canshuUl.find("li").each(function(){
                if($(this).find("span").html()=="undefined"){
                    $(this).find("span").html("");
                }
            });
        }
    });


}());