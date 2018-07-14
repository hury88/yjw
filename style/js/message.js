/**
 * Created by lianglong on 16/1/30.
 */

var big_content = $(".big_content"),
    info_rightUl = $(".info_right ul"),
    info_leftUl = $(".info_left ul"),
    get_mod_more = $(".get_mod_more");

var pageNumber = 2;

$.ajax({//获取左侧大图
    type: "GET",
    url: domainMess + "/zyanjing_service/service.do?key=QueryHotInfo",
    dataType: 'json',
    contentType: "text/plain; charset=utf-8",
    xhrFields: {
        withCredentials: true
    },
    success: function (data) {
        big_content.find("img").attr("src",imgHead+data.body.data.image_url);
        big_content.find("img").attr("data-id",data.body.data.info_id);
        big_content.find(".big_contentA").html(data.body.data.title);
        big_content.find(".big_contentA").attr("href","mesdetail.html?"+data.body.data.info_id+"&wiki");
        big_content.find(".topImgSrc").attr("href","mesdetail.html?"+data.body.data.info_id+"&wiki");
        big_content.find("p").html(data.body.data.create_time);
    }
});


$.ajax({//获取右侧热门
    type: "GET",
    url: domainMess + "/zyanjing_service/service.do?key=QueryHotPoint",
    dataType: 'json',
    contentType: "text/plain; charset=utf-8",
    xhrFields: {
        withCredentials: true
    },
    success: function (data) {
        info_rightUl.empty();
        for(var i=0;i<data.body.data.length;i++){
            info_rightUl.append('<li>'+
                '<div class="pic">'+
                '<a href="mesdetail.html?'+data.body.data[i].info_id+'&message" target="_blank"><img src='+imgHead+data.body.data[i].image_url+' class="pic-image" data-id='+data.body.data[i].info_id+'/></a>'+
                '</div>'+
                '<a class="info_rightullia" href="mesdetail.html?'+data.body.data[i].info_id+'&message" target="_blank">'+data.body.data[i].title+'</a>'+
                '<p>'+data.body.data[i].create_time+'</p>'+
                '</li>');
        }
    }
});

$.ajax({//获取信息列表
    type: "POST",
    url: domainMess + "/zyanjing_service/service.do?key=getCache",
    data:'{body:{keys:"XG_INFO_FIRST_PAGE"}}',
    dataType: 'json',
    contentType: "text/plain; charset=utf-8",
    xhrFields: {
        withCredentials: true
    },
    success: function (data) {
        console.log(data);
        info_leftUl.empty();
        for(var i=0;i<data.body.data.XG_INFO_FIRST_PAGE.list.length;i++){
            info_leftUl.append('<li>'+
                '<div class="xiao_content_left">'+
                '<a href="mesdetail.html?'+data.body.data.XG_INFO_FIRST_PAGE.list[i].info_id+'&message" target="_blank"><img src='+imgHead+data.body.data.XG_INFO_FIRST_PAGE.list[i].image_url+' class=" pic-image" data-id='+data.body.data.XG_INFO_FIRST_PAGE.list[i].info_id+'/></a>'+
                '</div>'+
                '<div class="xiao_content_right">'+
                '<a  href="mesdetail.html?'+data.body.data.XG_INFO_FIRST_PAGE.list[i].info_id+'&message" target="_blank">'+data.body.data.XG_INFO_FIRST_PAGE.list[i].title+'</a>'+
                '<p>'+data.body.data.XG_INFO_FIRST_PAGE.list[i].create_time+'</p>'+
                '</div>'+
                '<div class="clear"></div>'+
                '</li>');
        }
    }
});

//点击获取更多
get_mod_more.click(function(){
    $.ajax({
        type: "POST",
        url: domainMess + "/zyanjing_service/service.do?key=QueryInfoListByPage",
        dataType: 'json',
        data:'{body:{pageNo:'+pageNumber+',pageSize:"5"}}',
        contentType: "text/plain; charset=utf-8",
        xhrFields: {
            withCredentials: true
        },
        success: function (data){
            console.log(data);
            if(data.body.data.list.length==0){
                get_mod_more.hide();
            }else {
                for (var i = 0; i < data.body.data.list.length; i++) {
                    info_leftUl.append('<li>' +
                        '<div class="xiao_content_left">' +
                        '<a href="mesdetail.html?'+ data.body.data.list[i].info_id+'&message" target="_blank"><img src=' + imgHead + data.body.data.list[i].image_url + ' class=" pic-image" data-id='+ data.body.data.list[i].info_id+'/></a>'+
                        '</div>' +
                        '<div class="xiao_content_right">' +
                        '<a href="mesdetail.html?'+ data.body.data.list[i].info_id+'&message" target="_blank">' + data.body.data.list[i].title + '</a>' +
                        '<p>' + data.body.data.list[i].create_time + '</p>' +
                        '</div>' +
                        '<div class="clear"></div>' +
                        '</li>');
                }
                pageNumber++
            }
        }
    });
});

$(".zixun img").click(function(){
   window.open("http://www.zyanjing.com");
});