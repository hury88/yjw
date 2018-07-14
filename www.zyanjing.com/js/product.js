/**
 * Created by lianglong on 16/1/19.
 */
(function(){
    var leftUl = $(".left ul"),
        internal = $(".internal"),
        domestic = $(".domestic"),
        youzhi = $(".youzhi"),
        gongchang = $(".gongchang"),
        glassForeign = $(".glassForeign"),
        glassInland = $(".glassInland");
    	glassyouzhi = $(".glassyouzhi");
    	glassgongchang = $(".glassgongchang");

    var prodBrandVal = window.location.search;
    prodBrandVal = prodBrandVal.substr(1,prodBrandVal.length);
    var nextUrl = null,
        brandName = "";
    switch (parseInt(prodBrandVal)){
        case 0:
            glassForeign.html("国际品牌");
            glassInland.html("国内知名品牌");
            glassyouzhi.html("国内优质品牌");
            glassgongchang.html("工厂直供");
            nextUrl = "jpSelect.html?";
            break;
        case 4:
            glassForeign.html("镜架国际品牌");
            glassInland.html("镜架国内品牌");
            $(".addBlock").hide();
            nextUrl = "jjSelect.html?";
            break;
        case 6:
            glassForeign.html("老花镜品牌");
            glassInland.html("");
            $(".addBlock").hide();
            nextUrl = "jjSelect.html?";
            break;

        case 2:
            glassForeign.html("品牌");
            glassInland.html("品牌");
            $(".addBlock").hide();
            nextUrl = "jjSelect.html?";
            break;
        case 7:
            glassForeign.html("太阳镜国际品牌");
            glassInland.html("太阳镜国内品牌");
            $(".addBlock").hide();
            nextUrl = "jjSelect.html?";
            break;
    }



    $.ajax({
        type:"POST",
        url:domain+"/international_brand!getBrandTypeList.shtml?type_value="+prodBrandVal,
        dataType : 'json',
        contentType : "text/plain; charset=utf-8",
        success:function(data){
            console.log(data);
            leftUl.empty();
            internal.empty();
            domestic.empty();
            youzhi.empty();
            gongchang.empty();
            var leftVal = null;
            if(parseInt(prodBrandVal)==0){
                leftVal = "";
            }else {
                leftVal = "%"+prodBrandVal;
            }
            for(var i=0;i<data.brand_list.length;i++){

                if(data.brand_list[i].type_value==0){
                    brandName = "="+data.brand_list[i].brand_name;
                }else {
                    brandName = "";
                }
                leftUl.append('<li><a href="'+nextUrl+''+data.brand_list[i].brand_value+''+leftVal+''+brandName+'" target="_blank">'+data.brand_list[i].brand_name+'</a></li>');
                switch (parseInt(prodBrandVal)){
                    case 0://镜片
                        console.log(data);
                        switch(parseInt(data.brand_list[i].international)){//区分国内国外
                            case 0:

                                    if(data.brand_list[i].brand_image!=""){
                                        domestic.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                    }else{
                                        domestic.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                    }

                                break;
                            case 1:
                                if(data.brand_list[i].brand_image!=""){
                                    internal.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    internal.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }
                                break;
                            case 2:

                                if(data.brand_list[i].brand_image!=""){
                                    youzhi.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    youozhi.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }

                            break;
                            case 3:

                                if(data.brand_list[i].brand_image!=""){
                                    gongchang.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    gongchang.append('<li><a href="jpSelect.html?'+data.brand_list[i].brand_value+'='+data.brand_list[i].brand_name+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }

                            break;
                        }
                        break;
                    case 4://镜架或者太阳镜
                        switch(parseInt(data.brand_list[i].international)){//区分国内国外
                            case 0:

                                    if(data.brand_list[i].brand_image!=""){
                                        domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                    }else{
                                        domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                    }

                                break;
                            case 1:
                                if(data.brand_list[i].brand_image!=""){
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }
                                break;
                        }
                        break;

                    case 6://
                        switch(parseInt(data.brand_list[i].international)){//区分国内国外
                            case 0:

                                    if(data.brand_list[i].brand_image!=""){
                                        domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                    }else{
                                        domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                    }

                                break;
                            case 1:
                                if(data.brand_list[i].brand_image!=""){
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }
                                break;
                        }
                        break;

                    case 2://配件
                        switch(parseInt(data.brand_list[i].international)){//区分国内国外
                            case 0:

                                if(data.brand_list[i].brand_image!=""){
                                    domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }

                                break;
                            case 1:
                                if(data.brand_list[i].brand_image!=""){
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }
                                break;
                        }
                        break;
                    case 7://太阳眼镜
                        switch(parseInt(data.brand_list[i].international)){//区分国内国外
                            case 0:

                                if(data.brand_list[i].brand_image!=""){
                                    domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    domestic.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }

                                break;
                            case 1:
                                if(data.brand_list[i].brand_image!=""){
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src='+data.brand_list[i].brand_image+'></a></li>');
                                }else{
                                    internal.append('<li><a href="jjSelect.html?'+data.brand_list[i].brand_value+'%'+prodBrandVal+'" target="_blank"><img src="images/amn.jpg"></a></li>');
                                }
                                break;
                        }
                        break;
                }
            }
        },
        error:function(){
            console.log("链接失败");
        }
    });
}());