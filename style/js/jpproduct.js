$(function(){
	// var prodBrandVal = "1%0",
	var prodBrandVal = window.location.search,
		prodBrandVal = prodBrandVal.substr(1,prodBrandVal.length),
		allProArray = [];
	allProArray = prodBrandVal.split("=");
	allProArray[0] = allProArray[0];
	allProArray[1] = "0";
	var l = 0, loadN = 1;
	var box = $(".left .box"),  //左侧导航
		pinzhong = $(".pinzhong .options"),   //品种
		zheshelv = $(".zheshelv .options"),		//折射率
		bmsheji = $(".bmsheji .options"),      //表面设计
		moceng = $(".moceng .options"),			//膜层
		dingzhi = $(".dingzhi .options"),		//定制
		ranse = $(".ranse .options"),		//染色
		seban = $(".seban .options");     //色板

	var prod_series = '',  //系列
		big_prod_series = '',  //品种
		lens_refra_index = '',	//折射率
		lens_type = '',    //表面设计
		prod_film = '',   //膜层
		isfix = '',     //定制
		deytype = '',   //染色
		deycolor = '';   //色板
	var	del = $(".cond span.del"),	//全部撤销
		delS = $(".cond .con span i");	//删除其中某一个属性
	var jp_con = $(".jp_con"); //镜片列表
	var but =$(".but a");
	

	//banner图片
    function img(){
        $.ajax({
            type: "POST",
            url: domain + "/international_brand!getBrandInfo.shtml?brand_value="+allProArray[0],
            dataType: 'json',
            contentType: "text/plain; charset=utf-8",
            success: function (data) {
                console.log(data);
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
        	console.log(data)
        	box.empty();
        	for (var i=0;i<data.data.length;i++) {
        		box.append('<div class="list" data-index="'+data.data[i].theindex+'"><p><i class="add"></i><a href="javascript:;">'+data.data[i].value+'</a></p></list>');
        		$(".list[data-index="+allProArray[0]+"] a").addClass("active");
	        	$(".ppCon span").html($(".list[data-index="+allProArray[0]+"] a").html())
	        	if(box.find(".list").length == data.data.length){
	        		ppXilie();
	        	}
        	} 
        },
        error:function(){	
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
	        	console.log(data);
	        	$(".jj_option").empty();
	        	if(data.data.length>0){
	        		for (var i=0;i<data.data.length;i++) {
		        		li += '<li data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</li>';
		        		$(".jj_option").append('<a href="javascript:;" data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</a>')
		        		if($(".jj_option a").length == data.data.length){
		        			$(".jj_option a:first").addClass("active");
		        			
		        		}
		        	}
		        	
		        	$(".left .box .list[data-index='"+allProArray[0]+"']").append("<ul>"+li+"</ul>");
		        	$(".left .box .list[data-index='"+allProArray[0]+"']").find("li:eq(0)").addClass("on"); 
		        	$(".left .box .list[data-index='"+allProArray[0]+"'] i").removeClass("add");
		        	var q1 = data.data[0].index;
	        		prod_series = "&prod_series="+data.data[0].index;
	        		pinz(q1);
	        		zhesl(q1);
	        		biaomsj(q1);
	        		moc(q1);
	        		rans(q1);
	        		dingz(q1);
	        		seb(q1);
	        		jp_con.empty();
	                getSearchUrl();
	                proList();
	        	}else{
	        		$(".left .box .list[data-index='"+pinpai+"'] i").addClass("add");
	        		alert("下面没有系列了");
	        	}
	          },
	        error:function(){
	            console.log("链接失败");
	        }
	    })

    }
  


	

    function xilie(pinpai,n){
    	$.ajax({  // 获取某个品牌下面的所有系列
	        type:"POST",
	        url:domain+"/com_product!getFrameInfo.shtml?prod_brand="+pinpai+"&type=0&prod_type="+allProArray[1],
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	var li = '';
	        	console.log(data);
	        	$(".jj_option").empty();
	        	if(data.data.length>0){

	        		for (var i=0;i<data.data.length;i++) {
		        		$(".jj_option").append('<a href="javascript:;" data-index="'+data.data[i].theindex+'">'+data.data[i].value+'</a>');
		        		if($(".jj_option a").length == data.data.length){
		        			$(".jj_option a:eq("+n+")").addClass("active");
		        			
		        		}
		        	}
		        	var q1 = data.data[n].index;
	        		pinz(q1);
	        		zhesl(q1);
	        		biaomsj(q1);
	        		moc(q1);
	        		rans(q1);
	        		dingz(q1);
	        		seb(q1);
	        		jp_con.empty();
	                getSearchUrl();
	                proList();
	        	}else{
	        		$(".left .box .list[data-index='"+pinpai+"'] i").addClass("add");
	        		alert("下面没有系列了");
	        	}
	          },
	        error:function(){
	            console.log("链接失败");
	        }
	    })
    }

    function pinz(q1){   //筛选品种   q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getBigSeriesList.shtml?type_value="+allProArray[1]+"0&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	pinzhong.empty();
	        	var big_series_list = data.big_series_list.split(",");
	        	
	        	if(big_series_list.length>0){
	        		if(big_series_list == ''){
	        			$(".pinzhong").hide();
        			}else{
        				for (var i=0;i<big_series_list.length;i++) {
		        			if(!big_series_list[i] == ""){
		        				$(".pinzhong").show();
		        				pinzhong.append('<a href="javascript:;">'+big_series_list[i]+'</a>');
		        				 
		        			}
		        			if($(".pinzhong").find(".options").height()<50){
				                    $(".pinzhong").find("i").hide();
				                }else{
				                	$(".pinzhong").find("i").show();
				                }
			        	}
        			}
	        	}else{
	        		$(".pinzhong").hide();
	        	}	
	        	pinzhong.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();
	                big_prod_series = "&big_prod_series="+encodeURIComponent($(this).html());
	                getSearchUrl();
	                proList();
	            });
	        },
	        error:function(){}
	    })
    }

    function zhesl(q1){   //折射率加载  q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getRefractivityList.shtml?type_value="+allProArray[1]+"&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	zheshelv.empty();
	        	var zsl = data.refractivity_list.split(",");
	        	if(zsl.length>0){
	        		if(zsl == ''){
	        			$(".zheshelv").hide();
	        		}else{
	        			for (var i=0;i<zsl.length;i++) {
		        			if(!zsl[i] == ""){
		        				$(".zheshelv").show();
		        				zheshelv.append('<a href="javascript:;">'+zsl[i]+'</a>');
		        				
		        			}
		        			if($(".zheshelv").find(".options").height()<50){
			                    $(".zheshelv").find("i").hide();
			                }else{
			                	$(".zheshelv").find("i").show();
			                }
			        	}
	        		}
	        	}else{
	        		$(".zheshelv").hide();
	        	}
	        	zheshelv.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();
	                lens_refra_index = "&lens_refra_index="+$(this).html();
	                getSearchUrl();
	                proList();
	            });
	        	
	        },
	        error:function(){}
	    })
    }

    function biaomsj(q1){   //表面设计加载  q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getSurfaceDesignList.shtml?type_value="+allProArray[1]+"0&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	bmsheji.empty();
	        	if(data.surface_design_list.length>0){
	        		for (var i=0;i<data.surface_design_list.length;i++) {
	        			$(".bmsheji").show();
		        		bmsheji.append('<a href="javascript:;" data-value="'+data.surface_design_list[i].dict_value+'">'+data.surface_design_list[i].dict_label+'</a>');
		        		if($(".bmsheji").find(".options").height()<50){
		                    $(".bmsheji").find("i").hide();
		                }else{
		                	$(".bmsheji").find("i").show();
		                }
		        	}
	        	}else{
	        		$(".bmsheji").hide();
	        	}
	        	bmsheji.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();
	                lens_type = "&lens_type="+$(this).attr("data-value");
	                getSearchUrl();
	                proList();
	            });	
	        },
	        error:function(){}
	    })
    }

    function moc(q1){   //筛选膜层   q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getProdFilmList.shtml?type_value="+allProArray[1]+"0&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	moceng.empty();
	        	var prod_film_list = data.prod_film_list.split(",");
	        	if(prod_film_list.length>0){
	        		if(prod_film_list == ''){
	        			$(".moceng").hide();
	        		}else{
	        			for (var i=0;i<prod_film_list.length;i++) {
		        			if(!prod_film_list[i] == ""){
		        				$(".moceng").show();
		        				moceng.append('<a href="javascript:;">'+prod_film_list[i]+'</a>');
		        				
		        			}
		        			if($(".moceng").find(".options").height()<50){
			                    $(".moceng").find("i").hide();
			                }else{
			                	$(".moceng").find("i").show();
			                }
			        	}
	        		}	
	        	}else{
	        		alert("1")
	        	}
	        	moceng.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();

	                prod_film = "&prod_film="+encodeURIComponent($(this).html());
	                getSearchUrl();
	                proList();
	            });
	        },
	        error:function(){}
	    })
    }

    function rans(q1){   //筛选染色  q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getProdDeyTypeList.shtml?type_value="+allProArray[1]+"&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	ranse.empty();
	        	if(data.length>0){
	        		for (var i=0;i<data.length;i++) {
	        			$(".ranse").show();
		        		ranse.append('<a href="javascript:;">'+data[i].dictLabel+'</a>');
		        		if($(".ranse").find(".options").height()<50){
		                    $(".ranse").find("i").hide();
		                }else{
		                	$(".ranse").find("i").show();
		                }
		        	}
	        	}else{
	        		$(".ranse").hide();
	        	}	
	        	ranse.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();
	                deytype = "&deytype="+$(this).html();
	                getSearchUrl();
	                proList();
	            });
	        },
	        error:function(){}
	    })
    }

    function seb(q1){   //筛选色板   q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getProdDeyColorList.shtml?type_value="+allProArray[1]+"0&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	seban.empty();
	        	var prod_film_list = data.prod_film_list.split(",");
	        	if(prod_film_list.length>0){
	        		if(prod_film_list == ''){
	        			$(".seban").hide();
	        		}else{
	        			for (var i=0;i<prod_film_list.length;i++) {
	        				if(!prod_film_list[i] == ''){
	        					$(".seban").show();
	        					seban.append('<a href="javascript:;">'+prod_film_list[i]+'</a>');
	        				}
	        				if($(".seban").find(".options").height()<50){
			                    $(".seban").find("i").hide();
			                }else{
			                	$(".seban").find("i").show();
			                }
			        	}
	        		}
	        	}else{
	        		$(".seban").hide();
	        	}
	        	seban.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
	                jp_con.empty();
	                deycolor = "&deycolor="+$(this).html();
	                getSearchUrl();
	                proList();
	            });	
	        },
	        error:function(){}
	    })
    }

    function dingz(q1){   //筛选定制   q1为某系列
    	$.ajax({
	    	type:"POST",
	        url:domain+"/lens_brand_list!getProdisFixOrNot.shtml?type_value="+allProArray[1]+"0&prod_brand="+allProArray[0]+"&prod_series="+q1,
	        dataType : 'json',
	        contentType : "text/plain; charset=utf-8",
	        success:function(data){
	        	console.log(data)
	        	dingzhi.empty();
	        	if(data.length>0){
	        		for (var i=0;i<data.length;i++) {
	        			$(".dingzhi").show();
		        		dingzhi.append('<a href="javascript:;" data-value="'+data[i].dictValue+'">'+data[i].dictLabel+'</a>');
		        		if($(".dingzhi").find(".options").height()<50){
		                    $(".dingzhi").find("i").hide();
		                }else{
		                	$(".dingzhi").find("i").show();
		                }
		        	}
	        	}else{
	        		$(".dingzhi").hide();
	        	}	
	        	dingzhi.find("a").click(function(){
	        		but.html("显示更多");
        			but.css("background","#0093ff");
	        		loadN = 1;
			    	var t = $(this), index = t.attr("data-value");
			    	isfix = "&isfix="+index;
			    	getSearchUrl();
			        jp_con.empty();
			        proList();
			    })
	        },
	        error:function(){}
	    })
    }

    /* 左侧展开和收起 */
	$(document).on("click",".content .left .box .list p",function(){
		var t = $(this).find("i"), list = t.closest(".list"), index = list.attr("data-index");
		t.siblings("a").addClass("active");
		loadN = 1;
		allProArray[0] = list.attr("data-index");
		img();
		list.siblings(".list").find("p a").removeClass("active");
		$(".ppCon span").html(t.siblings("a").html());
		list.find("ul").remove();
		ppXilie();
	    list.find("ul").show();
		t.removeClass("add");
		list.siblings(".list").find("ul").hide();
		list.siblings(".list").find("i").addClass("add");	
		but.html("显示更多");
        but.css("background","#0093ff");
		dingzhi.find("a").removeClass("on");
		$(".cond").find(".con span").remove();
		big_prod_series = "";
        lens_refra_index = "";
        lens_type = "";
        prod_film = "";
        deytype = "";
        deycolor = "";
        isfix = "";
        xilie(allProArray[0],0);
	})

	/* 选择左侧系列 */
	$(document).on("click",".left .box .list li",function(){
		var t = $(this), index = t.index(), list = t.closest(".list").siblings(".list");
		loadN = 1;
		$(".jj_option a").eq(index).addClass("active").siblings().removeClass("active");
		allProArray[0] = t.closest(".list").attr("data-index");
		but.html("显示更多");
        but.css("background","#0093ff");
		dingzhi.find("a").removeClass("on");
		$(".cond").find(".con span").remove();
		t.addClass("on").siblings().removeClass("on");
		list.find("li").removeClass("on");
	    var xil = t.attr("data-index");
	    prod_series = "&prod_series="+xil;
	    l=1;
	    big_prod_series = "";
        lens_refra_index = "";
        lens_type = "";
        prod_film = "";
        deytype = "";
        deycolor = "";
        isfix = "";
        xilie(allProArray[0],index);
	    pinz(xil);
		zhesl(xil);
		biaomsj(xil);
		moc(xil);
		rans(xil);
		dingz(xil)
		seb(xil);

		
	})

	$(document).on("click",".jj_option a",function(){
		var t = $(this), index = t.index();
		t.addClass("active").siblings().removeClass("active");
		$(".left .box .list[data-index="+allProArray[0]+"] li").removeClass("on");
		$(".left .box .list[data-index="+allProArray[0]+"] li:eq("+index+")").addClass("on");
		var xil = t.attr("data-index");
	    prod_series = "&prod_series="+xil;
	    l=1;
	    big_prod_series = "";
        lens_refra_index = "";
        lens_type = "";
        prod_film = "";
        deytype = "";
        deycolor = "";
        isfix = "";
	    pinz(xil);
		zhesl(xil);
		biaomsj(xil);
		moc(xil);
		rans(xil);
		dingz(xil)
		seb(xil);
		loadN = 1;
		jp_con.empty();
        getSearchUrl();
        proList();
	})

	var w = 0;
	// 筛选结果url
     function getSearchUrl(){
        searchUrl = domain+"/lens_brand_list!getProdInfo.shtml?&prod_brand="+allProArray[0]+prod_series+big_prod_series+lens_refra_index+lens_type+prod_film+isfix+deytype+deycolor+"&type_value="+allProArray[1]+"&index="+loadN;
    }

    var loginAccount = loginName,
    loginPWD = loginPwd,
    custType = null,
    custId = null,
    custGrade = null,
    custName = null;
   
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
            	var li = '';
	        	
	        	if(data.product_list.length>0){
	        		but.html("显示更多");
                    but.css("background","#0093ff");
	        		for (var i=0;i<data.product_list.length;i++) {
		        		li += '<div class="jp_list" data-id="'+data.product_list[i].prod_id+'" data-lens="'+data.product_list[i].lens_type+'" prod_name="'+data.product_list[i].prod_name+'" data-isfix="'+data.product_list[i].isfix+'"><p class="name"><span class="kind"><a>'+data.product_list[i].prod_name+'</a></span><span class="launch"><i></i>点击展开</span><span class="ask"><a href="#"><i></i>询价</a></span></p></div>';	
		        	}
		        	jp_con.append(li);
		        	$(".jp_list:odd p").css("background","rgb(217, 232, 253)");
		        	
	        		if(jp_con.find(".jp_list").length == data.product_list.length){
		        		prod_id = "&prod_id="+data.product_list[0].prod_id;
		        		proD(0);
		        	}
		        	// if(jp_con.find(".jp_list").length == data.product_list.length){
		        		
		        	// }
		        	
		        	
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
	        	console.log(data)
	        	custName = data.XYanJ_C_Nam;
	            if(custName){
	                custId = data.XYanJ_C_id;
	                custType = data.custType;
	                custGrade = data.custGrade;
	                $(".fahuofang").show();
			    }
	        	$(document).on("click",".jp_con p.name",function(){//购物车
				    if(custId==""||custId=="null"||custId==null){
				        loginPop.fadeIn();
				    }else {

				        var t = $(this), list = t.closest(".jp_list");
						list.find("table").toggle();
						t.find("i").toggleClass("on");
						if(t.find("i").hasClass("on")){
							t.find("span.launch").html('<i class="on"></i>点击收起');
						}else{
							t.find("span.launch").html('<i></i>点击展开');
						}
						prod_id = "&prod_id="+ list.attr("data-id");
						w=1;
						var indexn = list.index();
						if(list.find("table").length == 0){;
							proD(indexn);
						}
						
				    }
				    return false;
				});						 			
	        },
	    });
	}	        		
		        	
		  //       alert(custId)
    // if(custId==""||custId=="null"||custId==null){
    // 	alert("1")
        
    // }

    function proD(n){ //加载商品里的数据  
    	$.ajax({
            type: "GET",
           	url: domain+"/multi_supplier!getMultiSupplierInfo.shtml?&prod_brand="+allProArray[0]+"&prod_type="+allProArray[1]+prod_id+prod_series,
            //url: domain+"/multi_supplier!getMultiSupplierInfo.shtml?prod_type=0&prod_id=107683&prod_brand=1&prod_series=468",
            dataType: 'json',
            contentType: "text/plain; charset=utf-8",
            cache:false,
            xhrFields:{
                withCredentials: true
            },
            success: function (data){
            	console.log(data)
        		console.log(domain+"/multi_supplier!getMultiSupplierInfo.shtml?&prod_brand="+allProArray[0]+"&prod_type="+allProArray[1]+prod_id+prod_series)
            	if(data.list.length>0){
            		var tr = '', price1 = 0;
            		var isfix1 = $(".jp_list").eq(n).attr("data-isfix");
            		var prodId1 = $(".jp_list").eq(n).attr("data-id");
            		var lens_type =$(".jp_list").eq(n).attr("data-lens");
            		var prod_name = $(".jp_list").eq(n).attr("prod_name");


	            	for (var i=0;i<data.list.length;i++) {
	            		if(isfix1 == 1){
	            			url = "dingzhi.html?isfix="+isfix1+"&prodType="+allProArray[1]+"&prod_id="+prod_id.substr(9)+'&supplier_id='+data.list[i].supplier_id+"&discount="+data.list[i].fix_discount+"&lens_type="+lens_type;
	            			price1 = data.list[i].original_price*data.list[i].fix_discount/100;
	            		}else{
	            			if($(".jp_list").eq(n).attr("data-lens") == 4){
	            				url = domain+"/cartSkuGradualJpInfo.jsp?isfix="+isfix1+"&prodType="+allProArray[1]+"&prodId="+prodId1+"&supplier_id="+data.list[i].supplier_id+"&discount="+data.list[i].unfix_discount;
	            			}else{
	            				url = domain+"/cartSkuJpInfo.jsp?isfix="+isfix1+"&prodType="+allProArray[1]+"&prodId="+prodId1+"&supplier_id="+data.list[i].supplier_id+"&discount="+data.list[i].unfix_discount;
	            			}
	            			price1 = data.list[i].original_price*data.list[i].unfix_discount/100;
	            		}
	            		//price1 = parseFloat(price1);
	            		price1 = getChildPrice(price1,true);
					
						
		                tr += '<tr data-id="'+data.list[i].supplier_id+'"><td width="200px">'+data.list[i].supplier_short_name+'</td><td width="190px"><span>'+price1+'</span>元/片起</td><td width="190">'+data.list[i].send_time+'天</td><td><span>¥'+data.list[i].normal_freight_price+'</span> / <span>¥'+data.list[i].sf_freight_price+'</span></td><td width="190px"><a href="'+url+'" target="_blank"><i></i>立刻下单</a></td></tr>';
						
	            		
	            		
	            	}
	            	$(".jp_list").eq(n).find("table").remove();
	            	$(".jp_list").eq(n).append('<table class="" width="100%" border=1 cellspacing=0 cellpadding=0><thead><tr><th>发货方</th><th>价格(元/片)</th><th>预计发货时间</th><th>普通快递费/顺丰快递费</th><th>下单支付</th></tr></thead><tbody>'+tr+'</tbody></table>');
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
						        	console.log(data)
						        	custName = data.XYanJ_C_Nam;
						            if(custName){
						                custId = data.XYanJ_C_id;
						                custType = data.custType;
						                custGrade = data.custGrade;
								    }
								    if(custId==""||custId=="null"||custId==null){
								        loginPop.fadeIn();
								    }else {
								    	$(".jp_list:first p span.launch").html('<i class="on"></i>点击收起')
								       jp_con.find(".jp_list:eq(0) table").show();
		        						jp_con.find(".jp_list:eq(0) i").addClass("on");
								    }
														 			
						        },
						    });
						}
	            	if($(".jp_list table").length ==1){
	            		jp_con.find(".jp_list:eq(0) table").show();
		        		jp_con.find(".jp_list:eq(0) i").addClass("on");
	            	}
            	}
            },
            error:function(){
            }
        })
    }

	// 筛选条件
	$(document).on("click",".options a",function(){
		var t = $(this), op = t.closest(".options");
		t.addClass("on").siblings("a").removeClass("on");
		var val = t.html(),
			id = op.attr("data-type");
		if(id == "3"||id == "5"){
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

	


	// 条件选择
	// $(document).on("click",".options a",function(){
	// 	var t = $(this), op = t.closest(".options");
	// 	t.addClass("on").siblings("a").removeClass("on");
	// 	var val = t.html(),
	// 		id = op.attr("data-type");
	// 	if(id == "3"||id == "5"){
	// 		value = t.attr("data-value");
	// 	}else{
	// 		value = 0;
	// 	}
	// 	if($(".cond .con").find('span[data-type="'+id+'"]').length>0){
	// 		$(".cond .con").find('span[data-type="'+id+'"]').html('<em>'+val+'</em><i></i>');
			
	// 	}else{
			
	// 		$(".cond .con").append('<span data-type="'+id+'" data-value="'+value+'"><em>'+val+'</em><i></i></span>');	
	// 	}	
	// })

	/**清除**/
    del.click(function(){
    	var t = $(this), cond = t.closest(".cond");
    	if($(".right .cond .con span").length>0){
    		cond.find(".con span").remove();
			$(".options a").removeClass("on");
			$(".jj_options a").eq(0).addClass("active").siblings().removeClass("active");
	        big_prod_series = "";
	        lens_refra_index = "";
	        lens_type = "";
	        prod_film = "";
	        deytype = "";
	        deycolor = "";
	        isfix = "";
	        loadN = 1;
	        getSearchUrl();
	        jp_con.empty();
	        proList();
	        but.html("显示更多");
       		 but.css("background","#0093ff");
	       
    	}
    });


	$(document).on('click','.cond .con span i',function(){
		var t = $(this), span = t.closest("span");
		var id = span.attr("data-type");
		$('.options[data-type="'+id+'"]').find("a").removeClass("on");
		switch(id){
			case 1:
				big_prod_series = "";
				break;
			case 2:
				lens_refra_index = "";
				break;
			case 3:
				lens_type = "";
				break;
			case 4:
				prod_film = "";
				break;
			case 5:
				isfix = "";
				break;
			case 6:
				deytype = "";
				break;
			case 7:
				deycolor = "";
				break;
		}
		span.remove();
		var t1 = $(".cond .con span[data-type='1']"),
		t2 = $(".cond .con span[data-type='2']"),
		t3 = $(".cond .con span[data-type='3']"),
		t4 = $(".cond .con span[data-type='4']"),
		t5 = $(".cond .con span[data-type='5']"),
		t6 = $(".cond .con span[data-type='6']"),
		t7 = $(".cond .con span[data-type='7']");

		if(t1.length == 1){
			big_prod_series = "&big_prod_series="+t1.find("em").html();
		}else{
			big_prod_series = "";
		}
		if(t2.length == 1){
			lens_refra_index = "&lens_refra_index="+t2.find("em").html();
		}else{
			lens_refra_index = "";
		}
		if(t3.length == 1){
			lens_type = "&lens_type="+t3.attr("data-value");
		}else{
			lens_type = "";
		}
		if(t4.length == 1){
			prod_film = "&prod_film="+t4.find("em").html();
		}else{
			prod_film = "";
		}
		if(t5.length == 1){
			isfix = "&isfix="+t5.attr("data-value");
		}else{
			isfix = "";
		}
		if(t6.length == 1){
			deytype = "&deytype="+t6.find("em").html();
		}else{
			deytype = "";
		}
		if(t7.length == 1){
			deycolor = "&deycolor="+t7.find("em").html();
		}else{
			deycolor = "";
		}
		loadN = 1;
		getSearchUrl();
        jp_con.empty();
        proList();
        but.html("显示更多");
        but.css("background","#0093ff");
	})

	but.click(function(){ // 加载更多
    	if(but.css("background") == "#ccc"){
    		return false;
    	}else{
    		if(jp_con.children().length>0){
		    	loadN++;
		        getSearchUrl();
		        proList();
		    }
    	}	
	});

	//右侧筛选条件的展开和收起
	$(".select .list i").click(function(){
		var t = $(this), list = t.closest(".list");
		list.toggleClass("all");
		
	})

	$(".select1 .list1 i").click(function(){
		var t = $(this), list = t.closest(".list1");
		list.toggleClass("all");
		
	})


	$(".bot_box li a").click(function(){
		var t = $(this), href = t.attr("data-href");
		window.open(domain+"/"+href);
	})

	// 右侧选择
     $(document).ajaxSuccess(function(){  
     	// alert($(".list .options").height())
     	// alert($(".list .options").html())
      //   if($(".list .options").height()>0){

      //      $(".content .right .select .list").each(function(){
      //           var t = $(this);
      //           if(t.find(".options").height()<50){
      //           	alert()
      //               t.find("i").hide();
      //           }else{
      //           	alert("1")
      //           	t.find("i").show();
      //           }
      //      })
      //   }
        if($(".list1 .options1").height()>0){
        	$(".content .right .select1 .list1").each(function(){
                var t = $(this);
                if(t.find(".options1").height()<50){
                    t.find("i").hide();
                }else{
                	t.find("i").show();
                }
           })
        }
    }); 


})

jQuery(document).ready(function ($) {
    "use strict";
    $('.content .left').perfectScrollbar();
});
