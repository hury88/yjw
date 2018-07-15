@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="/style/css/new/base.css">
<link rel="stylesheet" href="/style/css/new/order.css">
<link rel="stylesheet" href="/style/css/pagination.css">
<script src="js_source/jquery-1.9.0.js"></script>
<script type="text/javascript" src="/style/js_source/jquery.blockUI.js"></script>
<script src="/style/common/js/constant.js"></script>
<script src="/style/jqpage/js/jquery.pagination.js"></script>
<link href="images/favicon1.ico" rel="icon" type="image/x-icon">
<link rel="stylesheet" href="/style/css/bootstrap.css">
<link rel="stylesheet" href="/style/css/multiple-select.css">
<!-- <link rel="stylesheet" href="/style/css\new\base.css"> -->

<script>
$(function(){
	//分页div生成5,90
	var maxPage ="5";
	var pcount = "90";
	var current_page="1";
	$('.pagination').pagination(pcount, {
		callback : pageselectCallback,// PageCallback() 为翻页调用次函数。
		prev_text : " 上一页",
		next_text : "下一页 ",
		current_page: current_page-1,
		items_per_page : 20, // 每页的数据个数
		num_display_entries : 3, // 两侧首尾分页条目数
		num_edge_entries : 2
	// 连续分页主体部分分页条目数
});

	function pageselectCallback(page_id, jq) {
		var pageInfo = page_id + 1;
		$("#index").val(pageInfo);
		$("#index").val
		$("#inputForm").submit();
	}
})
</script>

<script>
var _payStatus = "";
var _pay_terms = "";
var _prodType = "";
var _prodBrand = "";
var orderId = "";
var startTime = "";
var endTime = "";
var orderType = "";
var orderStatus = "";
var parentMultiId = "";
$(document).ready(function() {
	function loadXML(xmlString){
		var xmlDoc=null;
        //判断浏览器的类型
        //支持IE浏览器
        if(!window.DOMParser && window.ActiveXObject){   //window.DOMParser 判断是否是非ie浏览器
        	var xmlDomVersions = ['MSXML.2.DOMDocument.6.0','MSXML.2.DOMDocument.3.0','Microsoft.XMLDOM'];
        	for(var i=0;i<xmlDomVersions.length;i++){
        		try{
        			xmlDoc = new ActiveXObject(xmlDomVersions[i]);
        			xmlDoc.async = false;
                    xmlDoc.loadXML(xmlString); //loadXML方法载入xml字符串
                    break;
                }catch(e){
                }
            }
        }
        //支持Mozilla浏览器
        else if(window.DOMParser && document.implementation && document.implementation.createDocument){
        	try{
                /* DOMParser 对象解析 XML 文本并返回一个 XML Document 对象。
                 * 要使用 DOMParser，使用不带参数的构造函数来实例化它，然后调用其 parseFromString() 方法
                 * parseFromString(text, contentType) 参数text:要解析的 XML 标记 参数contentType文本的内容类型
                 * 可能是 "text/xml" 、"application/xml" 或 "application/xhtml+xml" 中的一个。注意，不支持 "text/html"。
                 */
                 domParser = new  DOMParser();
                 xmlDoc = domParser.parseFromString(xmlString, 'text/xml');
             }catch(e){
             }
         }
         else{
         	return null;
         }

         return xmlDoc;
     }
     var xmlHttp;
     if(window.ActiveXObject){
     	$.ajax({
     		url:'DictionaryValueAction!getProductInfo.shtml',
     		type: 'post',
     		timeout: 10000,
     		error: function()
     		{
     		},
     		success: function(data)
     		{
					 //areaDoc = loadXML(data)
					 areaDoc = new ActiveXObject("Microsoft.XMLDOM");
					 areaDoc.async = false;
					 areaDoc.loadXML(data);

					 var provinces = areaDoc.getElementsByTagName("ProductType");
					 //省的SELECT
					 for (var i = 0; i < provinces.length; i++) {
					 	var id = provinces[i].getAttribute("ID");
					 	var name = provinces[i].getAttribute("NAME");
					 	$('#prodType').append("<option value='"+id+"'>"+name+"</option>");
					 }
					 if(_prodType!="")
					 {
					 	$('#prodType').val(_prodType);
					 	productTypeChange();
					 	$('#prodBrand').val(_prodBrand);
					 }

					}
				});
     }else{
     	xmlHttp = new XMLHttpRequest();
     	xmlHttp.open("GET","DictionaryValueAction!getProductInfo.shtml");
     	xmlHttp.onreadystatechange = callback;
     	xmlHttp.send(null);
     	function callback(){
     		if(xmlHttp.readyState == 4){
     			if(xmlHttp.status==200){
     				areaDoc = xmlHttp.response;
     				areaDoc = loadXML(areaDoc);
     				provinces = areaDoc.getElementsByTagName("ProductType");
					 //省的SELECT
					 for (var i = 0; i < provinces.length; i++) {
					 	var name = provinces[i].getAttribute("NAME");
					 	var id = provinces[i].getAttribute("ID");
					 	$('#prodType').append("<option value='"+id+"'>"+name+"</option>");
					 }
					 if(_prodType!="")
					 {
					 	$('#prodType').val(_prodType);
					 	productTypeChange();
					 	$('#prodBrand').val(_prodBrand);
					 }
					}
				}
			}
		}

		$.ajax({
			type: "GET",
			url: domain + '/member!getUserChildAccount.shtml',
			contentType: "text/plain; charset=utf-8",
			dataType : 'json',
			xhrFields: {
				withCredentials: true
			},
			success: function(data){
				console.log(data);
				console.log(data.parentMultiId);
				if(data.childAccountValue.length == 0){
					$('#childAccountMs').css('display', 'none');
					$('#msName').css('display', 'none');
					if(data.parentMultiId && data.parentMultiId != null){
						parentMultiId = data.parentMultiId;
					}
				}else{
					$('#childAccountMs').css('display', 'block');
					$('#msName').css('display', 'block');
					$('#childAccountMs').empty();
					for(var index = 0;index < data.childAccountValue.length; index++){
						$('#childAccountMs').append('<option value='+data.childAccountValue[index].cust_id+'>'+data.childAccountValue[index].cust_name+'</option>');
					}

					$('#childAccountMs').multipleSelect();
				}
			},
			error: function()
			{
			}
		});

		$("#excelExport").click(function(){
			if(parentMultiId != ''){
				alert("对不起,您没有导出权限!");
			}else{
				var orderId = $("#orderId").val();
				var orderEndtime = $("#orderEndtime").val();
				var orderStarttime = $("#orderStarttime").val();
				var childAccount = $("#childAccountMs").val();
				var payStatus = $("#payStatus").val();
				var payTerms = $("#pay_terms").val();
				var prodType = $("#prodType").val();
				var prodBrand = $("#prodBrand").val();
				var orderType = $("#orderType").val();
				var orderStatus = $("#orderStatus").val();
				window.location.href=domain + "/OrderAction!summaryOfConsumptionExport.shtml?orderId="+orderId+"&orderEndtime="+orderEndtime+"&orderStarttime=" +orderStarttime+"&childAccount="+childAccount
				+"&payStatus="+payStatus+"&payTerms="+payTerms+"&prodType="+prodType+"&prodBrand="+prodBrand+"&orderType="+orderType+"&orderStatus="+orderStatus;
			}

		});
	});



var brandList;
function productTypeChange(){
	var prodType = $('#prodType').val();
	//清空城市和区县的数据
	$('#prodBrand').empty();

	//追加城市的列表
	if(prodType != ""){
		$('#prodBrand').prepend("<option value=''>全部</option>");
		//var cities = areaDoc.selectNodes("//Province[@NAME='"+province+"']").nextNode().childNodes;
		if(window.ActiveXObject){
			brandList = areaDoc.selectNodes("//ProductType[@ID='"+prodType+"']").nextNode().childNodes;
		}else{
			brandList = provinces[document.getElementById("prodType").selectedIndex-1].getElementsByTagName("Brand") ;
		}
		//市的SELECT
		for (var i = 0; i < brandList.length; i++) {
			var id = brandList[i].getAttribute("ID");
			var name = brandList[i].getAttribute("NAME");
			$('#prodBrand').append("<option value='"+id+"'>"+name+"</option>");
		}
	}
	else
	{
		$('#prodBrand').prepend("<option value=''>全部</option>");
	}
}

</script>

@stop
@section('wapper')

@stop




<div class="head">
	<!-- 顶部 -->

	<div class="sideNav">
		<a href="javascript:;" class="muOrderBt"><p>我的订单</p><i></i></a>
		<a href="javascript:;" class="cartBt"><p>购物车</p><i class="gwc"></i></a>
		<!--         <a href="#"><p>充值</p><i class="cz"></i></a> -->
		<a href="#"><p>二维码</p><i class="ewm"></i></a>
		<a href="javascript:;"><p>回到顶部</p><i class="toTop"></i></a>
	</div>
	<script>
	var parentId = 'null'
	</script>
	<script src="/style/common/js/constant.js"></script>
	<script src="/style/js_new/login.js"></script>
	<script src="/style/js_new/common.js"></script>
	<script src="/style/js_new/allSearch.js"></script> 
	<!-- 面包屑 -->
	<div class="bread wrap">
		<a href="/">首页</a>><a href="#">订单管理</a>><a href="#">我的订单</a>
	</div>
	<!-- 内容部分 -->
	<div class="content wrap fn-clear">


		<script src="/style/common/js/jquery.cookie.js"></script>

		<div class="fn-left left">
    		@include('partial.mlefter')
		</div>
		<script>
		console.log(parentId);
		if(parentId != null && parentId != "" && parentId != 'null')
		{

		}
		else
		{
			if(0.0 > 0){
				$('.balance').html(0.0+"元");
			}

		}
		</script>
		<div class="fn-right right">
			<h3>我的订单</h3>
			<form id="inputForm" class="validate" method="post">
				<input type="hidden" id="index" name="index">
				<div class="p_order_search">
					<table width="95%" border="0" cellspacing="0" cellpadding="0" class="biaoge2">
						<tr>
							<td align="right" width="100px">订单开始时间：</td>
							<td align="left" width="150">
								<div class="single" style="width:158px;position:relative">
									<div class="rili_box">
										<i></i>
										<input class="runcode" id="orderStarttime" name="orderStarttime" type="text">
									</div>
								</div>
							</td>
							<td width="100"></td>
							<td align="right" width="100px"> 订单结束时间：</td>
							<td align="left">
								<div class="single" style="width:158px;position:relative">
									<div class="rili_box">
										<i></i>
										<input class="runcode" id="orderEndtime" name="orderEndtime" type="text">
									</div>
								</div>
							</td>
							<td width="100"></td>
							<td align="right" width="100px" id="msName">子账户：</td>
							<td align="left">
								<select id="childAccountMs" multiple="multiple" style="width:158px">
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">订单号：</td>
							<td><input type="text" id="orderId" name="orderId" class="p_countbox_head"></td>
							<td width="100"></td>
							<td align="right"> 是否支付：</td>
							<td align="left">
								<select id="payStatus" name="payStatus">
									<option value="">全部</option>
									<option value="0">未支付</option>
									<option value="1">已支付</option>
									<option value="10">按合同发货</option>   <!--仅限于有一部分合同支付+一部分在线支付 -->
								</select>
							</td>
							<td width="100"></td>
							<td align="right">支付方式：</td>
							<td align="left">
								<select id="pay_terms" name="pay_terms">
									<option value="">全部</option>
									<option value="0">支付宝</option>
									<option value="1">银联</option>
									<option value="2">余额</option>
									<option value="20">微信</option>
									<option value="3">余额和银联</option>
									<option value="4">余额和支付宝</option>
									<option value="21">微信和余额</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">产品类型：</td>
							<td align="left">
								<select name="prodType" id="prodType" onchange="productTypeChange()">
									<option value="">全部</option>
								</select>
							</td>
							<td width="100"></td>
							<td align="right"> 产品品牌：</td>
							<td align="left" colspan="3">
								<select name="prodBrand" id="prodBrand" onchange="" class="cities">
									<option value="">全部</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="right">订单类型：</td>
							<td align="left">
								<select id="orderType" name="orderType">
									<option value="">全部</option>
									<option value="0">普通订单</option>
									<option value="1">加工订单</option>
									<option value="2">代下单订单</option>
								</select></td>
								<td width="100"></td>
								<td align="right">订单状态：</td>
								<td align="left">
									<select id="orderStatus" name="orderStatus">
										<option value="">全部</option>
										<option value="0">已提交</option>
										<option value="1">已支付</option>
										<option value="4">已确认</option>
										<option value="2">已取消</option>
										<option value="3">已完成</option>
										<option value="5">加工完成</option>
										<option value="6">已发货</option>
									</select></td>
									<td width="100"></td>

									<td width="100" class="confirmButton">
										<a class="look">
											<input type="submit" class="p_btn_search">
										</a>
									</td>
									<td align="left" style='padding:0 10px' class="reconciliation">
										<a class="look">
											<input type="button" class="p_btn_search" id="excelExport" value="Excel对账单">
										</a>
									</td>
								</tr>
							</table>
						</div>
					</form>
					<div class="con">
						<table class="title" width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
							<thead>
								<tr height="40">
									<td width="165">订单号</td>
									<td>名称</td>
									<td width="65">数量</td>
									<td width="100">金额</td>
									<td width="95">支付状态</td>
									<td width="100">订单状态</td>
									<td width="85">操作</td>
								</tr>
							</thead>
						</table>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>
												<span><a href="skuOrderInfoCheck.html?orderId=1016210327680843776">1016210327680843776</a></span>
												<span>2018-07-09</span>
												<span>14:40:22</span>
											</div>
										</td>

										<td>
											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">
											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=121069&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.601&#38075;&#26230;A++&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">
												<span class="mon">&yen;272.00</span>
												<a target="_blank" href="orderSkuJpInfo.html?prodId=121069&orderId=1016210327680843776&orderDetailId=140892&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>
											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail.html?orderId=1016210327680843776">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1016210327680843776" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥11.84</span>
									<span>余额：¥260.16</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-1.html?orderId=1015801246604328960">1015801246604328960</a></span>





												<span>2018-07-08</span>
												<span>11:34:35</span>
											</div>
										</td>

										<td>

											<img src="http://image.zyanjing.com/productImages/main/20140805141600_743.jpg" class="p_pic_order">


											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=111768&discount=100.0000&sku_id=58336&supplier_id=20140522000006" target="_blank"></a>&#29790;&#24343;&#23572;&#30789;&#33014;&#40763;&#25176;CY011&#38145;&#24335;&#20013;&#21495;(250&#23545;/&#21253;)</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;40.00</span>



											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-1.html?orderId=1015801246604328960">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1015801246604328960" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>



									<!--全部微信-->



									<span>支付方式：余额：¥46.00</span>





									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-2.html?orderId=1013025188318543872">1013025188318543872</a></span>





												<span>2018-06-30</span>
												<span>19:43:37</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=121068&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#38075;&#26230;A++&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;184.00</span>





												<a target="_blank" href="orderSkuJpInfo-1.html?prodId=121068&orderId=1013025188318543872&orderDetailId=138037&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-2.html?orderId=1013025188318543872">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1013025188318543872" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>



									<!--全部微信-->



									<span>支付方式：余额：¥190.00</span>





									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="2">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-3.html?orderId=1011816302701969408">1011816302701969408</a></span>





												<span>2018-06-27</span>
												<span>11:40:54</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120741&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#38075;&#26230;A+&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;60.50</span>





												<a target="_blank" href="orderSkuJpInfo-2.html?prodId=120741&orderId=1011816302701969408&orderDetailId=137062&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="2">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="2">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="2">
											<div class="box">



												<a class="detail" href="skuOrderDetail-3.html?orderId=1011816302701969408">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1011816302701969408" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

									<tr>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120950&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#38075;&#26230;A4&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;160.00</span>





												<a target="_blank" href="orderSkuJpInfo-3.html?prodId=120950&orderId=1011816302701969408&orderDetailId=137063&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>





									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>



									<!--全部微信-->



									<span>支付方式：余额：¥226.50</span>





									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-4.html?orderId=1011099388061155328">1011099388061155328</a></span>





												<span>2018-06-25</span>
												<span>12:11:38</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120663&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.665&#20840;&#35270;&#32447;&#31532;&#19971;&#20195;&#65288;&#21464;&#28784;&#65289;&#38075;&#26230;A3&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;1024.00</span>





												<a target="_blank" href="orderSkuJpInfo-4.html?prodId=120663&orderId=1011099388061155328&orderDetailId=136549&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-4.html?orderId=1011099388061155328">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1011099388061155328" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥1024.00</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-5.html?orderId=1010789447798620160">1010789447798620160</a></span>





												<span>2018-06-24</span>
												<span>15:41:35</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120949&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.665&#38075;&#26230;A4&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;560.00</span>





												<a target="_blank" href="orderSkuJpInfo-5.html?prodId=120949&orderId=1010789447798620160&orderDetailId=136266&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-5.html?orderId=1010789447798620160">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1010789447798620160" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>

									<!--全部支付宝 -->


									<span>支付方式：支付宝：¥568.00</span>
									<span>余额：¥0.00</span>







									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-6.html?orderId=1010005583115321344">1010005583115321344</a></span>




												<span>2018-06-22</span>
												<span>11:44:52</span>
											</div>
										</td>

										<td>

											<img src="http://image.zyanjing.com/productImages/main/20141208175409_129.jpg" class="p_pic_order">


											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=113432&discount=100.0000&sku_id=58412&supplier_id=20170507000011" target="_blank"></a>&#34917;&#24046;&#20215;&#65288;&#36135;&#27454;&#12289;&#36816;&#36153;&#65289;</span>
										</td>
										<td width="65">40</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;40.00</span>



											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#30830;&#35748;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-6.html?orderId=1010005583115321344">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥40.00</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-6.html?orderId=1009685910154903552">1009685910154903552</a></span>





												<span>2018-06-21</span>
												<span>14:38:30</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120942&discount=89.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#19975;&#37324;&#36335;&#30591;&#35270;3.0F360&#20840;&#35270;&#32447;&#31532;&#19971;&#20195;&#21464;&#28784;&#38075;&#26230;A++&#65288;&#23450;&#21046;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;2403.00</span>




												<a href="http://www.zyanjing.com/dzInfo.html?orderId=1009685910154903552&prodId=120942&orderDetailId=135329" class="ddxqBT">查看光度</a>



											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-7.html?orderId=1009685910154903552">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1009685910154903552" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥2403.00</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-7.html?orderId=1002066896394125312">1002066896394125312</a></span>





												<span>2018-06-01</span>
												<span>15:57:03</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120948&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.601&#38075;&#26230;A4&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;320.00</span>





												<a target="_blank" href="orderSkuJpInfo-6.html?prodId=120948&orderId=1002066896394125312&orderDetailId=129634&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-8.html?orderId=1002066896394125312">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1002066896394125312" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>

									<!--全部支付宝 -->


									<span>支付方式：支付宝：¥326.00</span>
									<span>余额：¥0.00</span>







									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="3">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-8.html?orderId=1001738505669312512">1001738505669312512</a></span>





												<span>2018-05-30</span>
												<span>16:17:25</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120951&discount=89.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#38075;&#26230;A4&#38750;&#29699;&#38754;&#65288;&#23450;&#21046;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;237.63</span>




												<a href="http://www.zyanjing.com/dzInfo.html?orderId=1001738505669312512&prodId=120951&orderDetailId=129474" class="ddxqBT">查看光度</a>



											</div>
										</td>



										<td width="95" rowspan="3">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="3">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="3">
											<div class="box">



												<a class="detail" href="skuOrderDetail-9.html?orderId=1001738505669312512">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1001738505669312512" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

									<tr>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120950&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#38075;&#26230;A4&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;160.00</span>





												<a target="_blank" href="orderSkuJpInfo-7.html?prodId=120950&orderId=1001738505669312512&orderDetailId=129475&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>





									</tr>

									<tr>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120746&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#38075;&#26230;A3&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;264.00</span>





												<a target="_blank" href="orderSkuJpInfo-8.html?prodId=120746&orderId=1001738505669312512&orderDetailId=129476&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>





									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>

									<!--全部支付宝 -->


									<span>支付方式：支付宝：¥673.63</span>
									<span>余额：¥0.00</span>







									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-9.html?orderId=1000953439997394944">1000953439997394944</a></span>





												<span>2018-05-28</span>
												<span>12:15:11</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=123385&discount=97.0000&sku_id=&supplier_id=20141028000005" target="_blank"></a>&#34081;&#21496;A&#31995;&#21015;1.60&#65288;&#28949;&#33394;&#35270;&#30028;&#65289;&#21464;&#28784;&#33394;&#65288;&#28176;&#36827;&#23450;&#21046;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;722.66</span>




												<a href="http://www.zyanjing.com/dzInfo.html?orderId=1000953439997394944&prodId=123385&orderDetailId=128909" class="ddxqBT">查看光度</a>



											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-10.html?orderId=1000953439997394944">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=1000953439997394944" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥722.66</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>


												<span><a href="skuOrderInfoCheck-10.html?orderId=995671490084995072">995671490084995072</a></span>





												<span>2018-05-13</span>
												<span>22:26:12</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=121068&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#38075;&#26230;A++&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;184.00</span>





												<a target="_blank" href="orderSkuJpInfo-9.html?prodId=121068&orderId=995671490084995072&orderDetailId=125165&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21457;&#36135;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-11.html?orderId=995671490084995072">订单详情</a>


												<a href="confirmOrderTake.shtml?orderId=995671490084995072" class="confirm">
													确认收货
												</a>



											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥184.00</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-12.html?orderId=987647313373560832">987647313373560832</a></span>




												<span>2018-04-21</span>
												<span>19:00:43</span>
											</div>
										</td>

										<td>

											<img src="http://image.zyanjing.com/productImages/main/20180530142352_302.jpg" class="p_pic_order">


											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=123127&discount=100.0000&sku_id=183783&supplier_id=20150609000252" target="_blank"></a>&#30495;&#32500;&#26031;2018&#26032;&#27454;&#22826;&#38451;&#38236;2141C4</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;39.00</span>



											</div>
										</td>



										<td width="95" rowspan="1">&#24453;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21462;&#28040;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-12.html?orderId=987647313373560832">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-13.html?orderId=987595627879727104">987595627879727104</a></span>




												<span>2018-04-21</span>
												<span>15:35:20</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=123358&discount=100.0000&sku_id=&supplier_id=20140116000003" target="_blank"></a>&#21464;&#33394;&#29255;1.67&#38750;&#29699;&#38754;&#65288;&#33180;&#21464;&#33590;&#33394;&#65289;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;120.00</span>





												<a target="_blank" href="orderSkuJpInfo-10.html?prodId=123358&orderId=987595627879727104&orderDetailId=119312&prodType=0&lens_type=&isfix=0&discount=100.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24453;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21462;&#28040;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-13.html?orderId=987595627879727104">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-14.html?orderId=987589356183093248">987589356183093248</a></span>




												<span>2018-04-21</span>
												<span>15:10:25</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120619&discount=89.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.502&#30333;&#26230;&#29699;&#38754;&#65288;&#23450;&#21046;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;89.00</span>




												<a href="http://www.zyanjing.com/dzInfo.html?orderId=987589356183093248&prodId=120619&orderDetailId=119290" class="ddxqBT">查看光度</a>



											</div>
										</td>



										<td width="95" rowspan="1">&#24453;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21462;&#28040;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-14.html?orderId=987589356183093248">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-15.html?orderId=987316642872557568">987316642872557568</a></span>




												<span>2018-04-20</span>
												<span>21:06:45</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120625&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#38450;&#38654;&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;104.00</span>





												<a target="_blank" href="orderSkuJpInfo-11.html?prodId=120625&orderId=987316642872557568&orderDetailId=119138&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24453;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21462;&#28040;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-15.html?orderId=987316642872557568">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-16.html?orderId=987316240454254592">987316240454254592</a></span>




												<span>2018-04-20</span>
												<span>21:05:09</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120625&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#38450;&#38654;&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">1</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;104.00</span>





												<a target="_blank" href="orderSkuJpInfo-12.html?prodId=120625&orderId=987316240454254592&orderDetailId=119136&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24453;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#21462;&#28040;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-16.html?orderId=987316240454254592">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-17.html?orderId=980793641561751552">980793641561751552</a></span>




												<span>2018-04-02</span>
												<span>21:08:42</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120743&discount=80.0000&sku_id=&supplier_id=20171207000005" target="_blank"></a>&#20381;&#35270;&#36335;1.665&#38075;&#26230;A+&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;416.00</span>





												<a target="_blank" href="orderSkuJpInfo-13.html?prodId=120743&orderId=980793641561751552&orderDetailId=115038&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#23436;&#25104;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-17.html?orderId=980793641561751552">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>


									<!--全部微信-->


									<span>支付方式：微信：¥416.00</span>
									<span>余额：¥0.00</span>






									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-18.html?orderId=980711955620691968">980711955620691968</a></span>




												<span>2018-04-02</span>
												<span>15:45:42</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120654&discount=89.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.591&#23431;&#23449;PC&#29255;&#20840;&#35270;&#32447;&#31532;&#19971;&#20195;&#65288;&#21464;&#28784;&#65289;&#38075;&#26230;A+&#38750;&#29699;&#38754;&#65288;&#23450;&#21046;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;890.00</span>




												<a href="http://www.zyanjing.com/dzInfo.html?orderId=980711955620691968&prodId=120654&orderDetailId=114964" class="ddxqBT">查看光度</a>



											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#23436;&#25104;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-18.html?orderId=980711955620691968">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>

									<!--全部支付宝 -->


									<span>支付方式：支付宝：¥852.90</span>
									<span>余额：¥43.10</span>







									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="list">
							<table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#ccc">
								<tbody>

									<tr>

										<td width="165" rowspan="1">
											<div class="box">
												<span>&#26222;&#36890;&#35746;&#21333;</span>



												<span><a href="skuOrderDetail-19.html?orderId=980427839343951872">980427839343951872</a></span>




												<span>2018-04-01</span>
												<span>20:53:19</span>
											</div>
										</td>

										<td>


											<img src="newcs\img\glassStatic.jpg" class="p_pic_order">

											<span class="p_itemname"><a href="http://www.zyanjing.com/productDetail.html?prod_id=120967&discount=80.0000&sku_id=&supplier_id=20140207000002" target="_blank"></a>&#20381;&#35270;&#36335;1.552&#20840;&#35270;&#32447;&#31532;&#19971;&#20195;&#65288;&#21464;&#28784;&#65289;&#38075;&#26230;A+&#38750;&#29699;&#38754;&#65288;&#29616;&#29255;&#65289;</span>
										</td>
										<td width="65">2</td>
										<td width="100">
											<div class="box">


												<span class="mon">&yen;304.00</span>





												<a target="_blank" href="orderSkuJpInfo-14.html?prodId=120967&orderId=980427839343951872&orderDetailId=114798&prodType=0&lens_type=2&isfix=0&discount=80.0000" class="ddxqBT">查看光度</a>





											</div>
										</td>



										<td width="95" rowspan="1">&#24050;&#25903;&#20184;</td>
										<td width="100" rowspan="1">&#24050;&#23436;&#25104;</td>



										<td width="85" rowspan="1">
											<div class="box">



												<a class="detail" href="skuOrderDetail-19.html?orderId=980427839343951872">订单详情</a>




											</div>
										</td>

									</tr>

								</tbody>
							</table>

							<div class="bot">
								<p>
									<!--全部微信-->
									<span>支付方式：余额：¥304.00</span>
									<span>优惠：0.00元</span>

								</p>
							</div>


						</div>

						<div class="pagination" id="meneame"></div>
					</div>
				</div>
			</div>

			<script src="js\multiple-select.js"></script>
			<script src="js_new\lhgcore.min.js"></script>
			<script src="js_new\lhgcalendar.min.js"></script>
			<script>
			$('.oldData').click(function(){
				alert("如需对订单进行相关操作，请联系客服");
			});
			function initSelect()
			{

				if(orderId != "")
				{
					$("#orderId").val(orderId);
				}
				if(startTime != "")
				{
					$("#orderStarttime").val(startTime);
				}
				if(endTime != "")
				{
					$("#orderEndtime").val(endTime);
				}
				if(_payStatus != "")
				{
					$('#payStatus').val(_payStatus);
				}
				if(_pay_terms != "")
				{
					$('#pay_terms').val(_pay_terms);
				}
				if(_prodType != "")
				{
					$("#_prodType").val(_prodType);
				}
				if(_prodBrand != "")
				{
					$("#prodBrand").val(_prodBrand);
				}
				if(startTime != "")
				{
					$('.orderStarttime').val(startTime);
				}
				if(endTime != "")
				{
					$('.orderEndtime').val(endTime);
				}

				if(orderType != "")
				{
					$('#orderType').val(orderType);
				}

				if(orderStatus != "")
				{
					$('#orderStatus').val(orderStatus);
				}

			}
			initSelect();
			J(function(){
				J('#orderStarttime').calendar({ maxDate:'#orderEndtime' });
				J('#orderEndtime').calendar({ minDate:'#orderStarttime' });
			});
			</script>

			</html>
