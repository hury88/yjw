/**
 * Created by lianglong on 16/1/30.
 */


    var biaoti = $(".biaoti"),
        topicZhengwen2Ul = $(".topic-zhengwen2 ul"),
        topicZhengwenUl = $(".topic-zhengwen ul"),
        zixunLi = $(".zixun ul li");

var url = window.location.search;
url = url.substr(1,url.length);
var urlArray = [];
urlArray = url.split("&");
zixunLi.each(function(){
    if($(this).find("a").attr("href").indexOf(urlArray[1])>=0){
        zixunLi.removeClass("zixun_dangqian");
        $(this).addClass("zixun_dangqian");
    }
});

var keys = null,
    keyName = null,
    rightKeyName = null,
    urlKey = null;

switch (urlArray[1]){
    case "story":
        keys = urlArray[0];
        keyName = "QueryStoryDetail";
        rightKeyName = "QueryHotStoryPoint";
        urlKey = "story";
        break;
    case "wiki":
        keys = urlArray[0];
        keyName = "QueryBaikeDetail";
        rightKeyName = "QueryHotBaikePoint";
        urlKey = "wiki";
        break;
    case "message":
        keys = urlArray[0];
        keyName = "QueryInfoDetail";
        rightKeyName = "QueryHotPoint";
        urlKey = "message";
        break;
}



$.ajax({
    type: "POST",
    url: domainMess + "/zyanjing_service/service.do?key="+keyName,
    dataType: 'json',
    contentType: "text/plain; charset=utf-8",
    data:'{"body":{"infoId":"'+keys+'"}}',
    xhrFields: {
        withCredentials: true
    },
    success: function (data) {
        biaoti.find("h1").html(data.body.data.title);
        biaoti.find("p").html(data.body.data.create_time);
        biaoti.find("img").attr("src",imgHead+data.body.data.image_url);
        biaoti.parent().append(data.body.data.content);
    }
});


$.ajax({//获取右侧热门
    type: "GET",
    url: domainMess + "/zyanjing_service/service.do?key="+rightKeyName,
    dataType: 'json',
    contentType: "text/plain; charset=utf-8",
    xhrFields: {
        withCredentials: true
    },
    success: function (data) {
        console.log(data);
        topicZhengwen2Ul.empty();
        topicZhengwenUl.empty();
        for(var i=0;i<data.body.data.length;i++){
            //热门文章
            topicZhengwen2Ul.append('<li>'+
                '<div class="pic"><a href="mesdetail.html?'+data.body.data[i].info_id+'&'+urlKey+'" target="_blank"><img src='+imgHead+data.body.data[i].image_url+' class="pic-image"></a></div>'+
                '<a href="mesdetail.html?'+data.body.data[i].info_id+'&'+urlKey+'" target="_blank">'+data.body.data[i].title+'</a>'+
                '<p>'+data.body.data[i].create_time+'</p>'+
                '</li>');

            //可能感兴趣的文章
            topicZhengwenUl.append('<li><a href="mesdetail.html?'+data.body.data[i].info_id+'&'+urlKey+'" target="_blank">'+data.body.data[i].title+'</a> </li>');
        }
    }
});