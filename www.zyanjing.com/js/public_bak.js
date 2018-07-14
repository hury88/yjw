$(function(){
	var bannerLeftUlLi = $(".bannerLeftUl li");
	// 顶部
	$("span.triangle").hover(function(){
		var t = $(this);
		t.addClass("on");
	},function(){
		var t = $(this);
		t.removeClass("on");
	})

	// 导航
	$(".nav .all_goods li").hover(function(){
		var t = $(this);
		t.addClass("hei").siblings("li").removeClass("hei");
	})

	$(".nav .all_goods").hover(function(){
		var t = $(this);
		t.find("ul").stop().animate({height:"490px"},500);
	},function(){
		var t = $(this);
		t.find("ul").stop().animate({height:"0px"},500);
	})

	// 导航链接跳转
	 bannerLeftUlLi.click(function(){
            window.open("eyeglass.html?"+$(this).attr("data-value"));
        });
	// 回到顶部
	$(".toTop").click(function(){
		$('body,html').animate({scrollTop:0},1000); 
	})


	
})