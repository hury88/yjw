/**
 * Created by lianglong on 16/1/19.
 */
var domain = "http://www.zyanjing.com/zyanjing",

    domainX = "http://www.zyanjing.com/zyanjing",
    domainMess = "http://www.zyanjing.com",
    imgHead = "http://image.zyanjing.com";
    prevdomein = "http://www.zyanjing.com";
	ztradeDomain="http://image.zyanjing.com";
	
   var domain = "http://yjw.project/zyanjing",

    domainX = "http://yjw.project/zyanjing",
    domainMess = "http://192.168.1.26:8080",
    imgHead = "http://image.zyanjing.com";
    ztradeDomain="http://yjw.project";
    testimgHead="http://yjw.project/zyanjing_trade";
    prevdomein = "http://yjw.project/zgs_portal/";
   var defaultString = "协议价";

    function changeJson(){
   var urlParameter = window.location.search;
   urlParameter = urlParameter.substr(1,urlParameter.length);
   var urlJSON = urlParameter.split("&"),
       json = {};
   for(var i=0;i<urlJSON.length;i++){
      var unite = [];
      unite = urlJSON[i].split("=");
      json[unite[0]] = unite[1];
   }
   return json;
}
