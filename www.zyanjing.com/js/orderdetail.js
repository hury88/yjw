$(function(){
    var addInfo = $('.person .info');
    var orderDetailInfo = $('.right .con');
    var addressId = 0;
    var orderStatusBtn=null;
    var isCreate=true, ser_num;
    getOrderDetail();
    function getOrderDetail()
    {
        $.ajax({
            type:"POST",
            url:""+domain+"/getSkuOrderDetail.shtml?orderId="+orderId,
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){
                console.log(data);
                if(data != null)
                {
                    if(data.add_info != null && data.add_info.length > 0)
                    {
                        var tmpAddHtml = "";

                        var obj = data.add_info[0];
                        tmpAddHtml+='<div class="list fn-clear">'+
                            '<div class="fn-left infod" addressId ="'+obj.ser_num+'">'+
                            '<span class="active" >'+obj.con_name+'</span>';
                        addressId = obj.ser_num;
                        tmpAddHtml+= '<em>'+obj.province+'</em>'+
                            '<em>'+obj.cities+'</em>'+
                            '<em>'+obj.counties+'</em>'+
                            '<em>'+obj.street_add+'</em>'+
                            '<em class="tel">'+obj.telephone+'</em>';
                        if(obj.isDef == "0")
                        {
                            tmpAddHtml+='<i>默认地址</i>';

                        }
                        addInfo.append(tmpAddHtml);
                    }
                    if(data.order != null && data.order.length > 0)
                    {
                        for(var i=0; i < data.order.length; i++)
                        {
                            var orderItemHtml="";
                            //添加运费
                            orderItemHtml+='<div class="list fn-clear">'+
                                '<p class="way">配送方式</p>'+
                                '<div class="info">'
                            var tmpOder = data.order[i];
                            var freightHtml="";
                            for(var j=0;(tmpOder.freight != null && j < tmpOder.freight.length); j++)
                            {
                                if(tmpOder.freight[j].isSelected == "1")
                                {
                                    freightHtml+='<span class="active"  mode="'+tmpOder.freight[j].trans_mode+'"modename="'+tmpOder.freight[j].trans_name+'">'+tmpOder.freight[j].trans_name+'<i>&yen;'+getPrice(tmpOder.freight[j].price,true)+'</i></span>';
                                }

                            }
                            orderItemHtml+=freightHtml;

                            //添加订单商品
                            console.log("orderInf0"+tmpOder.orderInfo);
                            if(tmpOder.orderInfo != null && tmpOder.orderInfo.length > 0)
                            {
                                orderStatusBtn =  tmpOder.orderInfo[0];
                                if(orderStatusBtn.detail.prod_send_status == "1" || orderStatusBtn.detail.prod_send_status == "2")
                                {
                                    orderItemHtml+='<em class="express">快递公司：'+orderStatusBtn.detail.logi_com+'</em>'+
                                        '<em class="express">单号：'+orderStatusBtn.detail.logi_num+'</em>';
                                }
                                orderItemHtml+='<em class="day">预计发货时间'+tmpOder.orderInfo[0].detail.send_time+'天</em>'+
                                    '<em class="note">如需分批发货，请联系客服：18013382890,18013380871</em>'+
                                    '</div>';
                                var prodItemHtml = "";
                                prodItemHtml+='<p class="way">对应商品</p>'+
                                    '<table width="975" cellpadding="0" cellspacing="0" border="1" bordercolor="#ccc">'+
                                    '<thead><tr>'+
                                    '<td width="90">发货方</td>'+
                                    '<td width="125">图片</td>'+
                                    '<td>产品名称</td>'+
                                    '<td width="60">数量</td>'+
                                    '<td width="80">金额</td>'+
                                    '<td width="80">实收运费</td>'+
                                    '<td width="80">合计金额</td>'+
                                    '<td width="110">预计发货天数</td>'+
                                    '</tr></thead><tbody>';
                                var prodTrHtml="";

                                var begin = 0;

                                var same = 1;

                                var sameSupplierJson = [];
                                for(var sIndex = begin;sIndex < tmpOder.orderInfo.length; sIndex += same){
                                    same = 1;
                                    sameSupplierJson.push(begin);
                                    begin++;
                                    for(var nIndex = begin;nIndex <tmpOder.orderInfo.length; nIndex++){
                                        if(tmpOder.orderInfo[sIndex].detail.sale_id == tmpOder.orderInfo[nIndex].detail.sale_id){
                                            begin++;
                                            same++;
                                        }
                                    }
                                }
                                for(var pIndex = 0;  pIndex < tmpOder.orderInfo.length; pIndex++)
                                {
                                    var tmpProd =  tmpOder.orderInfo[pIndex];
                                    if($.inArray(pIndex,sameSupplierJson) != -1)
                                    {
                                        if($.inArray(pIndex,sameSupplierJson) + 1 < sameSupplierJson.length){
                                            prodTrHtml+='<tr><td rowspan="'+(sameSupplierJson[$.inArray(pIndex,sameSupplierJson) + 1] - sameSupplierJson[$.inArray(pIndex,sameSupplierJson)])+'">'+tmpProd.detail.supplier_name+'</td>';
                                        }else{
                                            prodTrHtml+='<tr><td rowspan="'+(tmpOder.orderInfo.length - sameSupplierJson[$.inArray(pIndex,sameSupplierJson)])+'">'+tmpProd.detail.supplier_name+'</td>';
                                        }
                                    }
                                    if(tmpProd.detail.prodImgPath != null && tmpProd.detail.prodImgPath != "")
                                    {
                                        prodTrHtml+='<td><img src="'+tmpProd.detail.prodImgPath+'"></td>';
                                    }
                                    else if(tmpProd.detail.prodType == '0' || tmpProd.detail.prodType == '1')
                                    {
                                        prodTrHtml+='<td><img src="newcs/img/glassStatic.jpg" class="p_pic_order" /></td>';
                                    }
                                    prodTrHtml+='<td>'+tmpProd.detail.prodName+'</td>'+
                                        '<td>'+tmpProd.detail.prodAmount+'</td>'+
                                        '<td><span class="mon">&yen;'+getPrice(tmpProd.detail.totalPrice,true)+'</span></td>';
                                    if(pIndex == 0)
                                    {
                                        prodTrHtml+='<td rowspan="'+tmpOder.orderInfo.length+'"><span class="fare">&yen;'+getPrice(tmpProd.detail.freightFeeReal,true)+'</span></td>'+
                                            '<td rowspan="'+tmpOder.orderInfo.length+'"  class="all"><span>&yen;</span></td>';
                                    }
                                    prodTrHtml+='<td>'+tmpProd.detail.send_time+'天</td></tr>';
                                }
                                prodItemHtml+=prodTrHtml;
                                prodItemHtml+='</tbody></table>';

                            }
                            orderItemHtml=orderItemHtml+prodItemHtml+"</div>";
                            orderDetailInfo.append(orderItemHtml);
                            if(orderStatusBtn.orderStatus == "6")
                            {
                                $('.order-btn').append('<a class="confirmSend">确认收货</a>');
                            }
                        }
                        //插入remark
                        $('#orderTxt').val(data.order[0].orderInfo[0].remark);
                    }
                }
                registerClick();
            }
        });
    }
    function registerClick()
    {
        // 合计
        var total = 0;
        var orderMoney=0;
        $(".list table").each(function(){
            var $t = $(this), single_mon = 0,fare=0;
            $t.find("tbody tr").each(function(){
                var t = $(this)
                var mon = parseFloat("0");
                console.log(t.find(".mon"));
                if(t.find(".mon").html() != undefined)
                {
                    console.log(t.find(".mon").html());
                    mon = parseFloat(t.find(".mon").html().substr(1));
                    orderMoney+=mon;
                    single_mon += mon;
                }
                console.log("single_mon="+single_mon);
                console.log();
                if(t.find(".fare").html() != undefined)
                {
                    fare = parseFloat(t.find(".fare").html().substr(1))
                    single_mon += fare;
                }

            })
            console.log("single_mon="+single_mon);
            $t.find(".all").html("&yen;"+getPrice(single_mon,true));
            total += single_mon;
        })
        console.log("total="+total);
        if(parseFloat(orderMoney) >= 1000)
        {
            $(".total .yfje i").html("&yen;"+getPrice(orderMoney,true));
        }
        else
        {
            $(".total .yfje i").html("&yen;"+getPrice(total,true));
        }

        $(".total .sum i").html("&yen;"+getPrice(total,true));
    }

    //确认收货
    $(document).on("click","a.confirmSend",function(){
        window.location.href = "confirmOrderTake.shtml?orderId=" + orderId;
    });

})