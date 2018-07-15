@extends('layouts.member')
@section('mcss')
<link rel="stylesheet" href="/style/css/new/cart.css">
@stop


@section('mianbaoxie')
<a href="#">账户管理</a>&gt;<a href="#">购物车</a>
@stop

@section('right')
<div class="price_head fn-clear">
	<div class="fn-left price_logo">
		<i></i>我的购物车
	</div>
	<div class="fn-right flow"></div>
</div>
<div class="havegoods">
 <div class="con">
		<ul class="title  fn-clear">
			<li class="b8">
			<li class="b44">商品名称</li>
			<li class="b12">数量</li>
			<li class="b12">合计金额</li>
			<li class="b12">发货方</li>
			<li class="b12 none">操作</li>
		</ul>
	</div>
	<ul class="total fn-clear">
		<li class="b8 fn-left">
			<input type="checkbox">
		</li>
		<li class="b44 fn-left">全选
			<span class="num">一共<em>0</em>件商品</span>
			<span class="sum">合计：<em>0.00</em>元</span>
		</li>
		<li class="fn-right btn">
			<a href="javascript:;" class="shopping">继续购物</a>
			<a class="compare">比价格</a>
			<a onclick="createOrder()" class="submit">提交订单</a>
		</li>
	</ul>
</div>
<form id="cartForm" action="cartOrder!createOrder.shtml">
<input type="hidden" name='cartIds' id="cartIds">
</form>
@stop


@section('right-outter')
<div class="overlay" style="padding-left: 25%;padding-top: 30%;display:none;">
	<img src="images\loading.gif" alt="">
</div>
<script>
var custType =1;
 var isCommitted = false;//表单是否已经提交标识，默认为false
 function dosubmit(cartIds){
    if(isCommitted==false){
    	$.blockUI({ message: $('.overlay') });
    	 $.ajax({
    		url:'cartOrder!createOrder.shtml',
    		type: 'post',
    		data: {"cartIds":cartIds},
    		error: function()
    		{

    			alert('操作失败!');
    			$.unblockUI({ message: $('.overlay') });

    		},
    		success: function(data)
    		{
    			if(parseInt(data) > 0)
    			{
    				isCommitted= true;
    				window.location.href="skuOrderInfoCheck.jsp?orderId="+data;
    			}
    			else
    			{

    				alert('操作失败!');
    				$.unblockUI({ message: $('.overlay') });
    			}
    		}

    	});
    }
}
function deleteCart(cartId)
{
	var bool = window.confirm("是否确认删除？");
	console.log("bool="+bool);
	if(bool){
		$.ajax({
		url:'cart!deleteCart.shtml',
		type: 'post',
		data: 'cartId='+ cartId,

		timeout: 10000,
		error: function()
		{
			alert('删除失败!');
		},
		success: function(data)
		{
			if(data == "-3"){
           		alert("请用手机查看商品详情");
           }else
          {
        	   window.location.reload();
          }
		}
		});
	}
}

//去结算事件
function createOrder(){
	console.log("custType="+custType);
	if(custType == '4')
	{
		alert("当前客户类型不支持下单，请联系客服！");
		return false;
	}
	//如果购物车列表为0
	if($("input[name='prod_check']").length == 0)
		return false;
	//判断是否选中商品
	var flag = false;
	var numFlag = true;
	//选择购物车的ID
	var cartIds = "";
	$("input[name='prod_check']").each(function(){
		if(this.checked){
			flag = this.checked;
			cartIds += $(this).parent().parent().attr("cart_id") + ",";
			var num = $(this).parent().parent().children('li').eq(2).find('p input[class=inputnum]').val();
			if(num == '' || (num != '' && parseInt(num) <= 0))
			{
				numFlag = false;
			}
		}
	});
	//如果没有选中购物车则返回
	if(!flag){
		alert("请选择一条或多条商品");
		return false;
	}
	if(!numFlag)
	{
		alert("请选择正确的数量");
		return false;
	}
	//如果选中一条或者多条则提交
	if(cartIds != ""){
		dosubmit(cartIds);
	}
}

//继续购物
$('.shopping').click(function(){
	window.location.href = prevdomein+"/index.html"
});

//比价格
var querydata ='';
var obj ={};
$('.compare').click(function(){
	if(parentId != null && parentId != "" && parentId != 'null')
	{
		alert("当前为子账户,没有权限执行该操作");
		return false;
	}
	//querydata =[];
	var numFlag = true;
	$("input[name='prod_check']").each(function(){
		if(this.checked){
			querydata+=$(this).parent().parent().attr("cart_id")+',';
			var num = $(this).parent().parent().children('li').eq(2).find('p input[class=inputnum]').val();
			if(num == '' || (num != '' && parseInt(num) <= 0))
			{
				numFlag = false;
			}
		}
	});
	if(!numFlag)
	{
		alert("请输入正确的数量!");
	}
	else if(querydata != '' && querydata.split(',').length >= 3 && querydata.split(',').length <=9)
	{
		$.blockUI({ message: $('.overlay') });
		window.location.href = "skuComparePrice.jsp?data="+querydata;
	}
	else
	{
		alert("请确认比价选择的产品数量，至少两条，最多不超过8条！");
	}

});

function modify(e1)
{
	editCartItem($(e1).parent().parent().attr("cart_id"),$(e1).parent().parent().attr("prod_id"),$(e1).parent().parent().attr("isfix"),$(e1).parent().parent().attr("prod_type"),$(e1).parent().parent().attr("supplier_id"),$(e1).parent().parent().attr("used_discount"),$(e1).parent().parent().attr("lens_type"));
}

function editCartItem(cartId,prodId,isfix,prodType,supplier_id,discount,lens_type){
	var tURL = "";
	if(prodType=="0")
	{
		if(isfix == "0")
		{
			if(lens_type=="4")
			{
				$.ajax({
					url:'cart!getSameSphCyl.shtml',
					type: 'post',
					data: 'cart_id='+ cartId,
					error: function()
					{
						alert('修改失败!');
					},
					success: function(data)
					{
						console.log(data);
						if(data == 1){
			           		alert("当前产品为渐进现片,存在相同球镜柱镜,请到手机端修改");
			           }else
			          {
			        	  window.open("cartSkuGradualJpInfo.jsp?isfix="+isfix+"&prodType="+prodType+"&prodId="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&cartId="+cartId);

			          }
					}
					});
				return false;
			}
			else
			{
				tURL="cartSkuJpInfo.jsp?isfix="+isfix+"&prodType="+prodType+"&prodId="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&cartId="+cartId;
			}

		}
 		else if(isfix == "1")
		{
			tURL="http://www.zyanjing.com/dingzhi.html?isfix="+isfix+"&prodType="+prodType+"&prod_id="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&cartId="+cartId+"&lens_type="+lens_type;
		}
	}
	else if(prodType == "6")
	{
		tURL="cartSkuJpInfo.jsp?isfix=0"+"&prodType="+prodType+"&prodId="+prodId+"&supplier_id="+supplier_id+"&discount="+discount+"&cartId="+cartId;
	}
	console.log("tURL="+tURL);
	if(tURL != "")
	{
		window.open(tURL);
	}

};
// 订单去结算
</script>
<script src="/style/js_new/cart.js"></script>
@stop
