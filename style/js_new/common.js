$(function(){
	// 顶部
	var parentId='<%=parentId%>';
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

	// 登录框
	$(".person .login").click(function(){
		var login = $(".login_box");
		login.fadeIn();
	})
	$(".login_box .close").click(function(){
		var login = $(".login_box");
		login.fadeOut();
	})


	// 回到顶部
	$(".toTop").click(function(){
		$('body,html').animate({scrollTop:0},1000); 
	})
})