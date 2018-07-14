/**
 * Created by lianglong on 16/1/22.
 */
var base_search_input = $(".search_text"),
    base_search_btn = $(".btn"),
    searchListUl = $(".searchList ul");


var productName = window.location.search;

var index = 1;//鍒嗛〉


console.log("productName="+productName);
if(productName!=""){
    productName = productName.substr(1,productName.length);
    base_search_input.val(decodeURI(productName));
    productName = encodeURI(base_search_input.val());

    searchListUl.empty();
    search();
}

base_search_input.focus(function(){
    document.onkeydown = function(e){
        if(base_search_input.val()!=""&&e.which==13){
            searchListUl.empty();
            productName = encodeURI(base_search_input.val());
            search();
        }
    };
});

base_search_btn.click(function(){
    searchListUl.empty();
    productName = encodeURI(base_search_input.val());
    search();
});



function search(){
    $.ajax({
        type: "POST",
        url:domain+"/dif_product!searchProduct.shtml?productName="+productName+"&index="+index,
        dataType: 'json',
        contentType: "text/plain; charset=utf-8",
        xhrFields:{
            withCredentials: true
        },
        success: function (data) {
            if(data.data.length == 0 || data.data == ""){
                $(".more a").html("宸插姞杞藉畬鎴�").css("background","#ccc");
            }
            var staticImg = "";

            for(var i=0;i<data.data.length;i++) {
                if(parseInt(data.data[0].prod_type)==0){
                    if(data.data[i].img_path==""){
                        staticImg = "images/glassStatic.jpg";
                    }else {
                        staticImg = data.data[i].img_path;
                    }
                }else {
                    staticImg = data.data[i].img_path;
                }
                var urlHtml = "";
                if(data.data[i].prod_type == "0")
                {
                    urlHtml+='<li>' +
                        '<a href="jpSelect.html?'+data.data[i].prod_brand+"="+data.data[i].prod_name+'" target="_blank">' +
                        '<div style="background: url('+staticImg+') center no-repeat"></div>' +
                        '<p>'+data.data[i].prod_name+'</p>' +
                        '</a>' +
                        '</li>';
                }
                else
                {
                    urlHtml+='<li>' +
                        '<a href="jjSelect.html?'+data.data[i].prod_brand+"%"+data.data[i].prod_type+'" target="_blank">' +
                        '<div style="background: url('+staticImg+') center no-repeat"></div>' +
                        '<p>'+data.data[i].prod_name+'</p>' +
                        '</a>' +
                        '</li>';
                }
                searchListUl.append(urlHtml);
            }
        }
    });
}

$(".more a").click(function(){
    index++;
    search();
})