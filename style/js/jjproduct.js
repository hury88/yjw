$(function(){
	var prodArray = [],
        loadN = 1,
        firstLoad = false,
        allProArray = [],
        prod_series = "",//产品系列url参数
        version = "",//型号
        prod_color = "",//色号
        mirr_width = "",//镜框尺寸
        nose_width = "",//鼻梁尺寸
        shapeArg = "",//框型
        styleArg = "",//款式
        supplier_id = "", //提供商
        order_by =""; //综合排序 价格排序 新品排序
	var prodBrandVal = window.location.search,
        prodBrandVal = prodBrandVal.substr(1,prodBrandVal.length),
	allProArray = prodBrandVal.split("%");
	var box = $(".left .box"),  //左侧导航
		jj_options = $(".jj_options"),  //右侧系列
		table = $(".jj_info table").eq(0), //系列对应列表
		filter_con = $(".filter_con"),  //框架列表
		but = $(".content .but a"),  //显示更多
		xinghao = $(".xinghao .options"),  //型号
		sehao = $(".sehao .options"),  //色号
		jkchicun = $(".jkchicun .options"),   //镜架尺寸
		blchicun = $(".blchicun .options"),  //鼻梁尺寸
		kuangxing = $(".kuangxing .options"),  //框型
		kuanshi = $(".kuanshi .options"), //款式
		del = $(".cond span.del"),	//全部撤销
		delS = $(".cond .con span i")	//删除其中某一个属性

		// 加入购物车
    var prod_id = "",  //商品id
    	price = "",  //原价
    	flag = "&flag=1",
    	sku_id = "",
    	discount = "",   //商品折扣
    	quantity = "";   //商品数量

		var l = 0;

    //banner图片
    function img(){
        $.ajax({
            type: "POST",
            url: domain + "/international_brand!getBrandInfo.shtml?brand_value="+allProArray[0],
            dataType: 'json',
            contentType: "text/plain; charset=utf-8",
            success: function (data) {
                $(".right .title img").attr("src",data.disc_img_path);
            }
        });
    }
    img();


	$.ajax({  // 获取所有品牌
        type:"POST",
        url:domain+"/com_product!getAllProdBrand.shtml?prod_type="+allProArray[1],
        dataType : 'json',
        contentType : "text/plain; charset=utf-8",
        success:function(data){
        	for (var i=0;i<data.data.length;i++) {
        		box.append('<div class="list" data-index="'+data.data[i].theindex+'"><p><i class="add"></i><a href="javascript:;">'+data.data[i].value+'</a></p></list>');
        		if(data.data[i].theindex == allProArray[0]){
        			$.ajax({  // 获取某个品牌下面的所有系列
				        type:"POST",
				        url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+allProArray[0]+"&type=0&prod_type="+allProArray[1],
				        dataType : 'json',
				        contentType : "text/plain; charset=utf-8",
				        success:function(data){
				        	var li = '';
				        	for (var i=0;i<data.data.length;i++) {
				        		li += '<li data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</li>';
				        	}
                            $(".ppCon span").html($(".content .left .list[data-index="+allProArray[0]+"] a").html());
                            $(".content .left .list[data-index="+allProArray[0]+"] a").addClass("active");
				        	$(".left .box .list[data-index='"+allProArray[0]+"']").append("<ul>"+li+"</ul>")
				        	if(l == 0 || $(".left .box .list[data-index='"+allProArray[0]+"'] ul").length == data.data[i].length){
				        		$(".left .box .list[data-index='"+allProArray[0]+"']").find("li:eq(0)").addClass("on");  //系列展开
				        	}
				          },
				        error:function(){
				            console.log("链接失败");
				        }
				    })
        		}
        	}
			$(".left .box .list[data-index='"+allProArray[0]+"']").find("i").removeClass("add");  //加号展开
          },
        error:function(){
            console.log("链接失败");
        }
    })

    function ppXilie(){
        $.ajax({  // 获取某个品牌下面的所有系列
            type:"POST",
            url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+allProArray[0]+"&type=0&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){
                var li = '';
                jj_options.empty();
                if(data.data.length>0){
                    for (var i=0;i<data.data.length;i++) {
                        jj_options.append('<a href="javascript:;" data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</a>');
                        jj_options.find("a:eq(0)").addClass("active");
                        li += '<li data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</li>'
                    }
                    $(".left .box .list[data-index='"+allProArray[0]+"']").append("<ul>"+li+"</ul>")
                    $(".left .box .list[data-index='"+allProArray[0]+"'] li:eq(0)").addClass("on");
                    order_by = "&order_by=0";
                    prod_series = "&prod_series="+data.data[0].theindex;
                    series()

                }


              },
            error:function(){
                console.log("链接失败");
            }
        })

    }


	/* 左侧展开和收起 */
	$(document).on("click",".left .box .list p",function(){
		var t = $(this).find("i"), list = t.closest(".list"), index = list.attr("data-index");
        loadN = 1;
        $(".ppCon span").html(list.find("a").html());

        list.find("a").addClass("active");
        list.siblings(".list").find("a").removeClass("active");
        allProArray[0] = index;
        list.find("ul").remove();
        ppXilie();
        img();
        $(".cond .con span").remove();
        version = "";
        prod_color = "";
        mirr_width = "";
        nose_width = "";
        shapeArg = "";
        styleArg = "";
        xh(index);
        sh(index);
        jkcc(index);
        blcc(index);
        kx(index);
        ks(index);
	    list.find("ul").show();
		t.removeClass("add");
		list.siblings(".list").find("ul").hide();
		list.siblings(".list").find("i").addClass("add");
	})

	var sa = 0;
	/* 选择左侧系列 */
	$(document).on("click",".left .box .list li",function(){
		var t = $(this), list = t.closest(".list").siblings(".list"), index = t.index();
		loadN = 1;
        jj_options.eq(0).find("a").eq(index).addClass("active").siblings().removeClass("active");
        jj_options.eq(1).find("a").eq(index).addClass("active").siblings().removeClass("active");
        t.closest(".list").find("a").addClass("active");
        list.find("a").removeClass("active");
		t.addClass("on").siblings().removeClass("on");
		list.find("li").removeClass("on");
        var indexF = t.closest(".list").attr("data-index");
		prod_series = "&prod_series="+t.attr("data-index"); //系列
        $(".cond .con span").remove();
        version = "";
        prod_color = "";
        mirr_width = "";
        nose_width = "";
        shapeArg = "";
        styleArg = "";
		// prodBrandVal = indexF+"%4";
		l = 1;
	    series();
        xh(indexF);
        sh(indexF);
        jkcc(indexF);
        blcc(indexF);
        kx(indexF);
        ks(indexF);
	})
 //    getSearchUrl();
	// proList();
    $.ajax({  // 获取某个品牌下面的所有系列
            type:"POST",
            url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+allProArray[0]+"&type=0&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){
                jj_options.empty();
                if(data.data.length>0){
                    for (var i=0;i<data.data.length;i++) {
                        jj_options.append('<a href="javascript:;" data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</a>');
                        jj_options.find("a:eq(0)").addClass("active");
                    }
                    order_by = "&order_by=0";
                    prod_series = "&prod_series="+data.data[0].theindex;
                    series()

                }


              },
            error:function(){
                console.log("链接失败");
            }
        })
	function xilie(n){

		$.ajax({  // 获取某个品牌下面的所有系列
	        type:"POST",
	        url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+allProArray[0]+"&type=0&prod_type="+allProArray[1],
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	jj_options.empty();
                if(data.data.length>0){
                    for (var i=0;i<data.data.length;i++) {
                        jj_options.append('<a href="javascript:;" data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</a>');
                        jj_options.eq(0).find("a").eq(n).addClass("active");
                        jj_options.eq(0).find("a").eq(n).siblings("a").removeClass("active");

                        jj_options.eq(1).find("a").eq(n).addClass("active");
                        jj_options.eq(1).find("a").eq(n).siblings("a").removeClass("active");
                    }
                    order_by = "&order_by=0";
                    prod_series = "&prod_series="+data.data[n].index;
                }


	          },
	        error:function(){
	            console.log("链接失败");
	        }
	    })
	}

    // 镜架滑动门
	$(document).on("click",".jj_options a",function(){
		var t = $(this), n = t.index(), tv = t.html(), tt = t.closest(".jj_options").attr("data-type");
		loadN = 1;
		t.addClass("active").siblings("a").removeClass("active");
		table.find("tbody").empty();
		prod_series = "&prod_series="+t.attr("data-index");
        t.closest(".calssify").siblings(".calssify").find("a").eq(n).addClass("active").siblings("a").removeClass("active");
		// getSearchUrl();
	 //    filter_con.empty();
	 //    proList();
        series();

	    $(".left .box .list[data-index='"+allProArray[0]+"'] li").eq(n).addClass("on").siblings().removeClass("on");
	})
    // series(0);
	function series(){
		$.ajax({  // 获取某个系列下的数据
	        type:"POST",
	        url:domain+"/multi_supplier!getMultiSupplierInfo.shtml?prod_type="+allProArray[1]+"&prod_brand="+allProArray[0]+prod_series,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        cache:false,
	        xhrFields:{
	            withCredentials: true
	        },
	        success:function(data){
	        	table.find("tbody").empty();
	        	if(data.list.length>0){
                    $(".jj_info").show()

	        		for (var i=0;i<data.list.length;i++) {
		        		table.find("tbody").append('<tr data-id="'+data.list[i].supplier_id+'"><td>'+data.list[i].supplier_short_name+'</td><td><span>'+getChildPrice(data.list[i].original_price*data.list[i].other_discount/100,true)+'</span>元/副起</td><td>'+data.list[i].send_time+'天</td><td><span>'+data.list[i].normal_freight_price+'</span>元/<span>'+data.list[i].sf_freight_price+'</span>元</td><td><p class="btn">选择</p></td></tr>');
                        if(table.find("tbody tr").length == data.list.length){
                            table.find("tbody tr:eq(0) .btn").addClass("on").html("已选");
                            table.find("tbody tr:eq(0)").siblings("tr").removeClass("on");
                            supplier_id = "&supplier_id="+data.list[0].supplier_id;
                        }
		        	}


	        	}else{
                    $(".jj_info").hide();
                    supplier_id = "&supplier_id="+'';
                }
                getSearchUrl();
                    filter_con.empty();
                    proList();

	          },
	        error:function(){
	            console.log("链接失败");
	        }
	    })
	}


	$(".filter a").click(function(){//综合排序、新品排序、价格排序
    	var t = $(this), ind = t.index();
    	t.addClass("active").siblings().removeClass("active");
    	loadN = 1;
    	but.html("显示更多");
        but.css("background","#0093ff");
        order_by = "&order_by="+ind;
        filter_con.empty();
        getSearchUrl();

        proList();
    })

    but.click(function(){ // 加载更多
    	var ind = $(".filter a.active").index();
    	if(but.css("background") == "#ccc"){
    		return false;
    	}else{
    		if(filter_con.children().length>0){
		    	loadN++;
		        getSearchUrl();

		        proList();
		    }
    	}
	});
    xh(allProArray[0]);
    sh(allProArray[0]);
    jkcc(allProArray[0]);
    blcc(allProArray[0]);
    kx(allProArray[0]);
    ks(allProArray[0]);

    /**获取型号**/
    function xh(pp){
        $.ajax({
            type:"POST",
            url:domain+"/com_product!getComProdInfo.shtml?prod_brand="+pp+"&type=0&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){
               xinghao.empty();
                if(data.data.length>0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i]!=null&&data.data[i]!=""){
                             $(".xinghao").show();
                            xinghao.append('<a href="javascript:;">' + data.data[i] + '</a>');
                        }
                    }
                }else {
                    $(".xinghao").hide();
                }
                /**产品系列搜索**/
                xinghao.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    version = "&version="+$(this).html();
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }

    /**获取色号**/
    function sh(pp){
        $.ajax({
            type:"POST",
            url:domain+"/com_product!getComProdInfo.shtml?prod_brand="+pp+"&type=1&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){

                sehao.empty();
                if(data.data.length>0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i]!=null&&data.data[i]!="") {
                            $(".sehao").show();
                            sehao.append('<a href="javascript:;">' + data.data[i] + '</a>');
                        }
                    }
                }else {
                    $(".sehao").hide();
                }
                /**色号搜索**/
                sehao.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    prod_color = "&prod_color="+$(this).html();
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });

    }

    /**获取镜框尺寸**/
    function jkcc(pp){
        $.ajax({
            type:"POST",
            url:domain+"/com_product!getComProdInfo.shtml?prod_brand="+pp+"&type=2&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){

                jkchicun.empty();
                if(data.data.length>0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i]!=null&&data.data[i]!="") {
                            $(".jkchicun").show();
                            jkchicun.append('<a href="javascript:;">' + data.data[i] + '</a>');
                        }
                    }
                }else {
                    $(".jkchicun").hide();
                }
                /**镜框尺寸搜索**/
                jkchicun.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    mirr_width = "&mirr_width="+$(this).html();
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }


    /**获取鼻梁尺寸**/
    function blcc(pp){
         $.ajax({
            type:"POST",
            url:domain+"/com_product!getComProdInfo.shtml?prod_brand="+pp+"&type=3&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){

                blchicun.empty();
                if(data.data.length>0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i]!=null&&data.data[i]!="") {
                            $(".blchicun").show();
                            blchicun.append('<a href="javascript:;">' + data.data[i] + '</a>');
                        }
                    }
                }else {
                    $(".blchicun").hide();
                }
                /**鼻梁尺寸搜索**/
                blchicun.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    nose_width = "&nose_width="+$(this).html();
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }

    /**获取框型**/
    function kx(pp){
        $.ajax({
            type:"POST",
            url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+pp+"&type=1&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){

                kuangxing.empty();
                if(data.data.length>0) {
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i].value!=null&&data.data[i].value!="") {
                            $(".kuangxing").show();
                            kuangxing.append('<a href="javascript:;" data-value=' + data.data[i].theindex + '>' + data.data[i].value + '</a>');
                        }
                    }
                }else {
                    $(".kuangxing").hide();
                }
                /**框型搜索**/
                kuangxing.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    shapeArg = "&shape="+$(this).attr("data-value");
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }


    /**获取款式**/
    function ks(pp){
        $.ajax({
            type:"POST",
            url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+pp+"&type=2&prod_type="+allProArray[1],
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){

                if(data.data.length>0) {
                    kuanshi.empty();
                    for (var i = 0; i < data.data.length; i++) {
                        if(data.data[i].value!=null&&data.data[i].value!="") {
                             $(".kuanshi").show();
                            kuanshi.append('<a href="javascript:;" data-value=' + data.data[i].theindex + '>' + data.data[i].value + '</a>');
                        }
                    }
                }else {
                    $(".kuanshi").hide();
                }

                /**款式搜索**/
                kuanshi.find("a").click(function(){
                    loadN = 1;
                    filter_con.empty();

                    styleArg = "&style="+$(this).attr("data-value");
                    getSearchUrl();
                    proList();
                });
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }



    // 筛选结果url
     function getSearchUrl(){
        searchUrl = domain+"/dif_product!getFrameList.shtml?index="+loadN+"&prod_brand="+allProArray[0]+prod_series+version+prod_color+mirr_width+nose_width+shapeArg+styleArg+supplier_id+order_by+"&prod_type="+allProArray[1];
    }

    var  loginPop = $(".loginPop");
    // 筛选结果
     function proList(){
        console.log(searchUrl);
       $.ajax({
            type: "GET",
            url: searchUrl,
            dataType: 'json',
            contentType: "text/plain; charset=utf-8",
            cache:false,
            xhrFields:{
                withCredentials: true
            },
            success: function (data){
            	console.log(data)
                if(data.data.length>0){
                    but.html("显示更多");
                    but.css("background","#0093ff");
                    for(var i=0;i<data.data.length;i++){
                    	var li = '';
                         if(data.data[i].market_price == "价格登录可见"){
                            var price1 = "价格登录可见";
                            var url = 'javascript:;'
                            filter_con.find("li:eq(i) .add_cart").addClass("hide");
                            var hide = 'hide';
                         }else{
                         	if(data.data[i].market_price == defaultString)
                         	{
                         		var price1 = data.data[i].market_price ;
	                            var url = 'productDetail.html?prod_id='+data.data[i].prod_id+'&discount='+data.data[i].discount+'&sku_id='+data.data[i].sku_id+'&supplier_id='+supplier_id.substr(13);
	                            var hide = '';
                         	}
                         	else
                         	{
	                         	var price1 = data.data[i].market_price*data.data[i].discount/100;
	                            var url = 'productDetail.html?prod_id='+data.data[i].prod_id+'&discount='+data.data[i].discount+'&sku_id='+data.data[i].sku_id+'&supplier_id='+supplier_id.substr(13);
                                var hide = '';
                         	}

                         }
                    	li += '<li data-value='+data.data[i].prod_id+' data-discount="'+data.data[i].discount+'" data-price="'+price1+'" data-sku="'+data.data[i].sku_id+'"><div class="con"><a class="img" href="'+url+'" target="_blank"><img src="'+data.data[i].path+data.data[i].big_img_path+'" alt=""></a><span><a href="'+url+'"  >'+data.data[i].prod_name+'</a></span><p>批发价：<em>'+price1+'</em></p><div class="cart fn-clear"><div class="jj"><i class="minus"></i><input type="text" value="1" ><i class="plus"></i></div><a href="javascript:;"  class="add_cart '+hide+'"><i></i>加入购物车</a></div></div></li>'
                        filter_con.append(li);
                    }
		         }else{
                    if(loadN == 1){
                        // alert($(".cond .con span").length)
                        if($(".cond .con span").length > 0){
                            but.html("没有筛选条件的商品");
                           but.css("background","#ccc");

                        }else{
                           but.html("显示更多");
                            but.css("background","#0093ff");
                        }

                    }else{
                        but.html("已经全部加载");
                        but.css("background","#ccc");
                    }

	        	}
            },
            error:function(){
                console.log("链接失败");
            }
        });
    }


     /**清除**/
    del.click(function(){
    	var t = $(this), cond = t.closest(".cond");
    	if($(".right .cond .con span").length>0){
    		cond.find(".con span").remove();
			$(".options a").removeClass("on");
			$(".jj_options a").eq(0).addClass("active").siblings().removeClass("active");
	        loadN = 1;

	        version = "";
	        prod_color = "";
	        mirr_width = "";
	        nose_width = "";
	        shapeArg = "";
	        styleArg = "";
	        getSearchUrl();
	        filter_con.empty();
	        proList();
    	}
    });


    /*----------- 筛选条件 -----------*/
 	$(document).on("click",".options a",function(){
		var t = $(this), op = t.closest(".options");
		t.addClass("on").siblings("a").removeClass("on");
		var val = t.html(),
			id = op.attr("data-type");
		if(id == "6"||id == "7"){
			value = t.attr("data-value");
		}else{
			value = 0;
		}
		if($(".cond .con").find('span[data-type="'+id+'"]').length>0){
			$(".cond .con").find('span[data-type="'+id+'"]').html('<em>'+val+'</em><i></i>');

		}else{

			$(".cond .con").append('<span data-type="'+id+'" data-value="'+value+'"><em>'+val+'</em><i></i></span>');
		}
	})

	$(document).on('click','.cond .con span i',function(){
		var t = $(this), span = t.closest("span");
		var id = span.attr("data-type");
		$('.options[data-type="'+id+'"]').find("a").removeClass("on");
		switch(id){
			case 2:
				 version = "";
				break;
			case 3:
				prod_color = "";
				break;
			case 4:
				mirr_width = "";
				break;
			case 5:
				nose_width = "";
				break;
			case 6:
				shapeArg = "";
				break;
			case 7:
				styleArg = "";
				break;
		}
		span.remove();
		var t2 = $(".cond .con span[data-type='2']"),
		t3 = $(".cond .con span[data-type='3']"),
		t4 = $(".cond .con span[data-type='4']"),
		t5 = $(".cond .con span[data-type='5']"),
		t6 = $(".cond .con span[data-type='6']"),
		t7 = $(".cond .con span[data-type='7']");
		if(t2.length == 1){
			version = "&version="+t2.find("em").html();
		}else{
			version = "";
		}
		if(t3.length == 1){
			prod_color = "&prod_color="+t3.find("em").html();
		}else{
			prod_color = "";
		}
		if(t4.length == 1){
			mirr_width = "&mirr_width="+t4.find("em").html();
		}else{
			mirr_width = "";
		}
		if(t5.length == 1){
			nose_width = "&nose_width="+t5.find("em").html();
		}else{
			nose_width = "";
		}
		if(t6.length == 1){
			shapeArg = "&shape="+t6.attr("data-value");
		}else{
			shapeArg = "";
		}
		if(t7.length == 1){
			styleArg = "&style="+t7.attr("data-value");
		}else{
			styleArg = "";
		}
        loadN = 1;
		getSearchUrl();
        filter_con.empty();

        proList();

	})


	// 选择发货方
    $(document).on("click","p.btn",function(){
		var t = $(this), tr = t.closest("tr").siblings("tr");
		t.addClass("on").html("已选");
		tr.find("p.btn").removeClass("on").html("选择");
		supplier_id = "&supplier_id="+t.closest("tr").attr("data-id");
		getSearchUrl();
        filter_con.empty();

        proList();
	})

	// 加入购物车
	// 数量加
	$(document).on("click","i.plus",function(){
		var t = $(this), input = t.siblings("input");
		var val = parseInt(input.val());
			val++;
		input.val(val);

	})
	// 数量减
	$(document).on("click","i.minus",function(){
		var t = $(this), input = t.siblings("input");
		var val = parseInt(input.val());
		if(val>1){
			val--;
		}
		input.val(val);

	})
	//数量输入
	$(document).on("keyup",".jj input",function(){
		this.value = this.value.replace(/[^\d]/g,'');
	})
	// 购物车动画
	$(document).on("click",".add_cart",function(){
		var t =$(this),li = t.closest("li"), offset = $("i.gwc").offset(),
	        m = t.offset(),
	        scH = $(window).scrollTop();
	        prod_id = "&prod_id="+li.attr("data-value");
	        price = "&price="+li.attr("data-price");
	        discount = "&discount="+li.attr("data-discount");
	        quantity = "&quantity="+li.find("input").val();
            sku_id = "&sku_id="+li.attr("data-sku")

        var img = li.find('img').attr('src');//获取当前点击图片链接
        var flyer = $('<img class="flyer-img" src="' + img + '">');//抛物体对象

        //检查是否已经登录
        checkHasLogin();
        function checkHasLogin(){
            $.ajax({
                type: "GET",
                url: domain + "/member!getUserInfo.shtml",
                contentType: "text/plain; charset=utf-8",
                dataType : 'json',
                async:false,
                xhrFields: {
                    withCredentials: true
                },
                success: function (data) {

                    custName = data.XYanJ_C_Nam;
                    if(custName){
                        custId = data.XYanJ_C_id;
                        custType = data.custType;
                        custGrade = data.custGrade;

                    }

                    if(custId==""||custId=="null"||custId==null){
                        loginPop.fadeIn();
                    }else {
                        if(allProArray[1] == 6){
                        	window.open(domain+"/cartSkuJpInfo.jsp?isfix=0&prodType="+allProArray[1]+"&prodId="+li.attr("data-value")+supplier_id+discount);
                        	//var tempwindow=window.open('_blank');
                        	//tempwindow.location = domain+"/cartSkuJpInfo.jsp?isfix=0&prodType="+allProArray[1]+"&prodId="+li.attr("data-value")+supplier_id+discount;
                        }else{
                            if(supplier_id.substr(13) == ''){
                                alert("没有发货商，无法加入购物车！")
                            }else{
                                $.ajax({
                                    type:"POST",
                                    url:domain+"/zyanjing/cart!addToCart.shtml?"+prod_id+quantity+flag+sku_id+supplier_id,
                                    dataType : 'json',
                                    contentType : "text/plain; charset=utf-8",
                                    cache:false,
                                    xhrFields:{
                                        withCredentials: true
                                    },
                                    success:function(data){
                                        flyer.fly({
                                            start: {
                                                left: m.left+5, //抛物体起点横坐标
                                                top: m.top-scH-10////抛物体起点纵坐标
                                            },
                                            end: {
                                                left: offset.left + 10, //抛物体终点横坐标
                                                top: offset.top-scH + 10, //抛物体终点纵坐标
                                                width:10,
                                                height:10
                                            },
                                            onEnd: function(){
                                                this.destory();//销毁抛物体
                                            }
                                        });
                                    },
                                    error:function(){
                                        alert("加入商品失败");
                                    }
                                })
                            }
                        }
                    }
                },
            });
        }
	})

	//镜架种类下拉框
	$(".select .list i").click(function(){
		var t = $(this), list = t.closest(".list");
		list.toggleClass("all");

	})


    // 系列按钮悬浮

    function calssify(){
        var h = $(".calssify1").offset().top+60;
        var l = $(".calssify1").offset().left;
        $(".calssify2").css("left",l);
        $(window).bind("scroll", function(){
            if($(document).scrollTop()>h){
                $(".calssify2").show();
            }else{
                $(".calssify2").hide();
            }

        })
    }
    calssify();
    window.onresize = function(){
        var h = $(".calssify1").offset().top;
        var l = $(".calssify1").offset().left;
        $(".calssify2").css("left",l);
    };

    // 右侧选择
     $(document).ajaxSuccess(function(){
     	$(".content .right .select .list i").eq(4).hide();
     	$(".content .right .select .list i").eq(5).hide();
        /*if($(".options").height()>0){
           $(".content .right .select .list").each(function(){
                var t = $(this);
                if(t.find(".options").height()<50){
                    t.find("i").hide();
                }
           })
        }*/
    });
    //检查是否已经登录
    checkHasLogin();
    function checkHasLogin(){
        $.ajax({
            type: "GET",
            url: domain + "/member!getUserInfo.shtml",
            contentType: "text/plain; charset=utf-8",
            dataType : 'json',
            xhrFields: {
                withCredentials: true
            },
            success: function (data) {

                custName = data.XYanJ_C_Nam;
                if(custName){
                    custId = data.XYanJ_C_id;
                    custType = data.custType;
                    custGrade = data.custGrade;
                    $(".fahuofang").show();
                }
            },
        });
    }
    $(document).on("click","ul.filter_con .con a.img,ul.filter_con .con span a",function(){
        $.ajax({
            type: "GET",
            url: domain + "/member!getUserInfo.shtml",
            contentType: "text/plain; charset=utf-8",
            dataType : 'json',
            xhrFields: {
                withCredentials: true
            },
            success: function (data) {

                custName = data.XYanJ_C_Nam;
                if(custName){
                    custId = data.XYanJ_C_id;
                    custType = data.custType;
                    custGrade = data.custGrade;

                }
                if(custId==""||custId=="null"||custId==null){
                    loginPop.fadeIn();
                }


            },
        });
    })


})

jQuery(document).ready(function ($) {
    "use strict";
    $('.content .left').perfectScrollbar();
});

