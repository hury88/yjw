$(function(){
	 var  bannerLeftUlLi = $(".bannerLeftUl li"),
   timeT = 60000;;
     $(".quanbushangping .banner_left .bannerLeftUl li").hover(function(){
      	$(this).find("i").css("background-position-x","-30px");
     },function(){
      	$(this).find("i").css("background-position-x","0");
     });
     $(".quanbushangping").hover(function(){
      	$(".bannerLeftUl").stop().slideDown();
     },function(){
       	$(".bannerLeftUl").stop().slideUp();
     });
    

    bannerLeftUlLi.click(function(){
        window.open("eyeglass.html?"+$(this).attr("data-value"));
    });
    

    

  
})