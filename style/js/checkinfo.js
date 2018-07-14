$(function(){
    var addInfo = $('.person .info');
    var orderDetailInfo = $('.right .con');
    var addressId = 0;
    var orderStatusBtn=null;
    var orderStatus='0';
    var isCreate=true, ser_num;
    var hasDef = -1;

    $('.setaddr').hide();
    getOrderDetail();
    //按合同发货
    function confirmSend(orderId,payAmount){
        var flag = true;
        var transFlag = true;
        //必须选择收货地址
        $(".infod span").each(function(){
            if($(this).hasClass("active")){
                flag = false;
            }
        });

        if(flag){
            alert("请选择一个收货地址");
            event.returnValue = false;
            return false;
        }
        //必须选择收货地址
        $(".info span").each(function(){
            if($(this).hasClass("active")){
                transFlag = false;
            }
        });

        if(transFlag){
            alert("请选择一个快递");
            event.returnValue = false;
            return false;
        }

        $.blockUI({ message: $('.overlay') });
        setBuyerTxt();
        $.ajax({
            url:'order!confirmSend.shtml',
            type: 'post',
            data: {"orderId":orderId,"payAmount":payAmount},
            timeout: 10000,
            error: function()
            {
                alert('操作失败!');
                $.unblockUI({ message: $('.overlay') });
            },
            success: function(data)
            {
                window.location.href='skuhtpay.jsp?orderId='+orderId+"&payway=0&freight="+encodeURI(encodeURI($('.con .info span.active').attr("modename")));
            }
        });
    }
    function setBuyerTxt(){
        var orderTxt = $("#orderTxt").val();

        $.ajax({
            url:'order!setOrderTxt.shtml',
            type: 'post',
            data: {"orderId":orderId,"orderTxt":orderTxt},
            timeout: 10000,
            error: function()
            {
                alert('操作失败!');
            },
            success: function(data)
            {
            }
        });
    }

    function payTotalMoney(){
        var addflag = true;
        var transFlag = true;
        //必须选择收货地址
        $(".infod span").each(function(){
            if($(this).hasClass("active")){
                addflag = false;
            }
        });

        if(addflag){
            alert("请选择一个收货地址");
            event.returnValue = false;
            return false;
        }

        //快递选择
        //必须选择收货地址
        $(".trans-list span").each(function(){
            if($(this).hasClass("active")){
                transFlag = false;
            }
        });
        if(transFlag){
            alert("请选择一种快递");
            event.returnValue = false;
            return false;
        }
        $.blockUI({ message: $('.overlay') });
        setBuyerTxt();
        window.location.href = 'skupayway.jsp?orderId='+orderId+"&payway=0";
    }
    function getOrderDetail()
    {
        hasDef = -1;
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
                        for(var index=0; index < data.add_info.length; index++)
                        {
                            var obj = data.add_info[index];
                            if(index == 0 )
                            {
                                if(obj.isOrderAdd == '1')
                                {
                                    tmpAddHtml+='<div class="list fn-clear">'+
                                        '<div class="fn-left infod" addressId ="'+obj.ser_num+'"isChild="'+obj.isChild+'">'+
                                        '<span class="active" >'+obj.con_name+'</span>';
                                    addressId = obj.ser_num;
                                }
                                else
                                {
                                    tmpAddHtml+='<div class="list fn-clear ">'+
                                        '<div class="fn-left infod" addressId ="'+obj.ser_num+'">'+
                                        '<span >'+obj.con_name+'</span>';
                                }
                                if(obj.isDef == '0')
                                {
                                    hasDef=1;
                                }

                            }
                            else
                            {
                                tmpAddHtml+='<div class="list fn-clear fn-hide">'+
                                    '<div class="fn-left infod" addressId ="'+obj.ser_num+'">'+
                                    '<span >'+obj.con_name+'</span>';
                            }
                            tmpAddHtml+= '<em>'+obj.province+'</em>'+
                                '<em>'+obj.cities+'</em>'+
                                '<em>'+obj.counties+'</em>'+
                                '<em>'+obj.street_add+'</em>'+
                                '<em class="tel">'+obj.telephone+'</em>';
                            if(obj.isChild == '0')   //当前不是主账户的地址
                            {
                                if(obj.isDef == "0")
                                {
                                    tmpAddHtml+='<i>默认地址</i>';
                                    tmpAddHtml+='</div>'+
                                        '<div class="fn-right operate">'+
                                        '<a href="javascript:;" class="edit" isDef="0">编辑</a>'+
                                        '</div></div>';

                                }else{
                                    tmpAddHtml+='</div>'+
                                        '<div class="fn-right operate">'+
                                        '<a href="javascript:;" class="edit" isDef="1">编辑</a>'+
                                        '<a href="javascript:;" class="delete">删除</a>'+
                                        '</div></div>';
                                }
                            }
                            else
                            {
                                tmpAddHtml+='</div></div>';
                            }
                        }
                        addInfo.append(tmpAddHtml);
                    }
                    var moreHtml = "";
                    if(data.add_info != null && data.add_info.length > 1)
                    {
                        moreHtml+='<div class="more"><a href="javascript:;">更多地址<i></i></a></div>';
                    }
                    else if(data.add_info == null || data.add_info != null && data.add_info.length < 1)
                    {
                        moreHtml+='<div class="addOrderAdd"><a class="add" style="cursor:pointer">添加订单收货地址<i></i></a></div>';
                    }
                    addInfo.append(moreHtml);
                    if(data.order != null && data.order.length > 0)
                    {
                        for(var i=0; i < data.order.length; i++)
                        {
                            var orderItemHtml="";
                            //添加运费
                            orderItemHtml+='<div class="list fn-clear">'+
                                '<p class="way">配送方式</p>'+
                                '<div class="info trans-list">'
                            var tmpOder = data.order[i];
                            var freightHtml="";
                            for(var j=0;(tmpOder.freight != null && j < tmpOder.freight.length); j++)
                            {
                                if(tmpOder.freight[j].isSelected == "1")
                                {
                                    freightHtml+='<span class="active"  mode="'+tmpOder.freight[j].trans_mode+'"modename="'+tmpOder.freight[j].trans_name+'"supplierId="'+tmpOder.orderInfo[0].detail.sale_id+'">'+tmpOder.freight[j].trans_name+'<i>&yen;'+getPrice(tmpOder.freight[j].price,false)+'</i></span>';
                                }
                                else
                                {
                                    freightHtml+='<span mode="'+tmpOder.freight[j].trans_mode+'"supplierId="'+tmpOder.orderInfo[0].detail.sale_id+'">'+tmpOder.freight[j].trans_name+'<i>&yen;'+getPrice(tmpOder.freight[j].price,false)+'</i></span>';
                                }

                            }
                            if(tmpOder.freight == null || tmpOder.freight != null && tmpOder.freight.length < 1)
                            {
                                freightHtml+='<span class="addOrderAdd  orderColor">当前无快递信息</span>';
                            }
                            orderItemHtml+=freightHtml;

                            //添加订单商品
                            if(tmpOder.orderInfo != null && tmpOder.orderInfo.length > 0)
                            {
                                orderStatusBtn =  tmpOder.orderInfo[0];
                                orderItemHtml+='<em class="day">预计发货时间'+tmpOder.orderInfo[0].detail.send_time+'天</em>'+
                                    '<em class="note">如需分批发货,请联系客服:025-88816163</em>'+
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
                        }
                        console.log("orderStatusBtn="+orderStatusBtn);
                        if(orderStatusBtn != null)
                        {
                            console.log("orderStatus="+orderStatusBtn.orderStatus+"onlinePaySum="+orderStatusBtn.onlinePaySum);
                            orderStatus = orderStatusBtn.orderStatus;
                            if((orderStatusBtn.orderStatus == "1"  && orderStatusBtn.payStatus == "0") || orderStatusBtn.orderStatus == "0") //取消订单
                            {
                                $('.order-btn').append('<a class="cancel">取消订单</a>');
                            }
                            if(orderStatusBtn.orderStatus == "0" || orderStatusBtn.orderStatus == "1")
                            {
                                if(parentId == null || parentId == '' || parentId == 'null' ||(parentId != null && parentId != '' && parentId !='null' && isPay == '1'))
                                {
                                    if(orderStatusBtn.payStatus == "0" && orderStatusBtn.onlinePayAmount == 0 )
                                    {
                                        //显示按合同发货和全额支付
                                        $('.order-btn').append('<a class="totalpay">支付</a>');
                                        if(isContract == '1')
                                        {
                                            $('.order-btn').append('<a class="htpay">按合同发货</a>');
                                        }

                                    }
                                    if(orderStatusBtn.onlinePaySum == 0 && orderStatusBtn.onlinePayAmount > 0)
                                    {
                                        $('.order-btn').append('<a class="totalpay">支付</a>');
                                    }
                                }
                            }
                            if(orderStatusBtn.orderStatus == "6")
                            {
                                $('.order-btn').append('<a class="confirmSend">确认收货</a>');
                            }
                        }

                        //插入remark
                        $('#orderTxt').val(data.order[0].orderInfo[0].remark);
                    }
                    registerClick();
                }

            }
        });
    }

    //客户选择收货地址
    function registerClick()
    {
        // 选择收货地址
        $(".list .infod span").click(function(){
            var t = $(this), list = t.closest(".list");
            if(t.parent().attr("isChild") == '1')
            {
                alert("当前为子账户地址，无法选择");
                return false;
            }
            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            $.ajax({
                type:"POST",
                url:""+domain+"/updateOrderAddress.shtml?orderId="+orderId+"&addressId="+t.parent().attr("addressId"),
                dataType : 'json',
                contentType : "text/plain; charset=utf-8",
                success:function(data)
                {
                    if(data > 0)
                    {
                        t.addClass("active").siblings("span").removeClass("active");
                        window.location.reload()
                    }
                    else
                    {
                        alert("更新失败");
                    }
                }
            });

            t.find("span").addClass("active");
            list.siblings(".list").find("span").removeClass("active");
        })

        // 删除默认地址
        $(".delete").click(function(){
            if(parentId != null && parentId != '' && parentId != 'null')
            {
                alert("当前为子账号，不支持修改地址，请联系老板修改");
                return false;
            }

            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            var t = $(this), list = t.closest(".list"),
                index = list.index();
            if(confirm("确定要删除该地址吗？")){
                if($(".info .list").length ==1){
                    alert("只剩一个地址了！！！");
                    return false;
                }

                //发送ajax 删除地址：
                $.ajax({
                    type:"POST",
                    url:""+domain+"/address!deleteMyAddress.shtml?ser_nums="+t.parent().prev().attr("addressid")+",",
                    dataType : 'json',
                    contentType : "text/plain; charset=utf-8",
                    success:function(data)
                    {
                        if(data > 0)
                        {
                            window.location.reload()
                        }

                    }
                });
            }

        })

        // 新增地址和修改地址的弹出层
        $(".add").click(function(){
            alert(1)
            if(parentId != null && parentId != "" && parentId != 'null')
            {
                alert("当前为子账号，不支持修改地址，请联系老板修改");
                return false;
            }
            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            isCreate= true;
            $(".grey,.popup").fadeIn();
            createNewAddress(true,"","","");
        });

        $(".edit").click(function(){
            if(parentId != null && parentId != "" && parentId != 'null')
            {
                alert("当前为子账号，不支持修改地址，请联系老板修改");
                return false;
            }
            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            isCreate = false;
            var t = $(this).parent().prev("div");  //存储收货信息的地方
            ser_num = t.attr("addressid");
            $(".person #con_name").val(t.find("span").html());
            $(".grey,.popup").fadeIn();

            var province = t.find("em:eq(0)").html();
            var city = t.find("em:eq(1)").html();
            var country = t.find("em:eq(2)").html();

            var address = t.find("em:eq(3)").html();

            var telPhone = t.find("em:eq(4)").html();

            if(address != undefined){
                $("input[name=street_add]").val(address);
            }
            if(telPhone != undefined)
            {
                $("input[name=telephone]").val(telPhone);
            }
            if($(this).attr("isDef") == "0")
            {
                $("input[id=isdef]").attr("checked",true);
            }
            else
            {
                $("input[id=isdef]").attr("checked",false);
            }
            console.log("province="+province+"city="+city+"country="+country);
            createNewAddress(false,province,city,country);

        });

        //设置为默认地址
        $(".operate .set").click(function(){
            if(parentId != null && parentId != "" && parentId != 'null')
            {
                alert("当前为子账号，不支持修改地址，请联系老板修改");
                return false;
            }
            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            var t = $(this).parent().prev();
            $.ajax({
                type:"POST",
                url:""+domain+"/address!setDef.shtml?sernums="+t.attr("addressid"),
                dataType : 'json',
                contentType : "text/plain; charset=utf-8",
                success:function(data)
                {
                    if(data > 0)
                    {
                        window.location.reload()
                    }

                }
            });
        });

        $("#con_name").change(function(){
            checkName();
        })
        $(".validate select").change(function(){
            checkStreet();
        })
        $("#street_add").change(function(){
            checkStreet1();
        })
        $("#telephone").change(function(){
            checkTelephone();
        })
        $("#zip").change(function(){
            checkZip();
        })


        $(".modify_submit").click(function(){
            checkName();
            checkStreet();
            checkTelephone();
            checkZip();
            checkStreet1();
            if(validate()){
                var con_name = $('#con_name').val();
                var province = $('#province').val();
                var cities = $('#cities').val();
                var counties = $('#counties').val();
                var street_add = $('#street_add').val();
                var fix_telephone = $('#fix_telephone').val();
                var telephone = $('#telephone').val();
                var zip = $('#zip').val();

                var checkbox = document.getElementById('isdef');
                if(hasDef == 1)
                {
                    isDef = checkbox.checked?'0':'1';
                }
                else
                {
                    isDef = '0';
                }
                if(isCreate)
                {
                    var data={};
                    data.orderId = orderId;
                    data.con_name=encodeURIComponent(con_name);
                    data.province= encodeURIComponent(province);
                    data.cities= encodeURIComponent(cities);
                    data.counties=encodeURIComponent(counties);
                    data.street_add=encodeURIComponent(street_add);
                    data.fix_telephone=fix_telephone;
                    data.telephone=telephone;
                    data.zip=zip;
                    data.isDef=isDef;
                    $.ajax({
                        type:"POST",
                        url:""+domain+"/updateOrderNewAddress.shtml?data="+JSON.stringify(data),
                        dataType: 'json',
                        contentType: "text/plain; charset=utf-8",
                        success:function(data)
                        {
                            if(data > 0)
                            {
                                window.location.reload();
                            }
                            else
                            {
                                alert("创建新地址失败");
                            }
                        }
                    });
                }
                else
                {
                    $.ajax({
                        type:"POST",
                        url:""+domain+"/address!addressMyUpdate.shtml?ser_nums="+ser_num+"&con_name="+encodeURIComponent(con_name)+"&province="+encodeURIComponent(province)+"&cities="+encodeURIComponent(cities)+"&counties="+encodeURIComponent(counties)+"&street_add="+encodeURIComponent(street_add)+"&fix_telephone="+fix_telephone+"&telephone="+telephone+"&zip="+zip+"&isDef="+isDef,
                        // data: {"ser_nums":ser_num,"con_name":encodeURIComponent(con_name),"province":encodeURIComponent(province),"cities":encodeURIComponent(cities),"counties":encodeURIComponent(counties),"street_add":encodeURIComponent(street_add),"fix_telephone":fix_telephone,"telephone":telephone,"zip":zip,"isDef":isDef},
                        dataType: 'json',
                        contentType: "text/plain; charset=utf-8",
                        success:function(data)
                        {
                            if(data > 0)
                            {
                                window.location.reload();
                            }
                        }
                    });
                }
            }

        });

        $(".modify_cancel").click(function(){
            $(".grey,.popup").hide();
        })

        $(".close,.grey").click(function(){
            $(".grey,.popup").hide();
        })

        // 选择快递
        $(".con .info span").click(function(){
            if(orderStatus != '0')
            {
                alert("请检查订单是否已支付或者已取消");
                return false;
            }
            var t = $(this);
            $.ajax({
                type:"POST",
                url:""+domain+"/updateOrderTransMode.shtml?orderId="+orderId+"&addressId="+addressId+"&transmode="+t.attr("mode")+"&supplierId="+t.attr("supplierId"),
                dataType : 'json',
                contentType : "text/plain; charset=utf-8",
                success:function(data)
                {
                    if(data > 0)
                    {
                        window.location.reload()
                    }

                }
            });

        })

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
            //$(".all span").html("&yen;"+parseFloat(single_mon))
            total += single_mon;
        })
        console.log("total="+total);
//		if(parseFloat(orderMoney) >= 500)
//		{
//			$(".total .yfje i").html("&yen;"+getPrice(orderMoney,true));
//		}
//		else
//		{
//			$(".total .yfje i").html("&yen;"+getPrice(total,true));
//		}
        $(".total .yfje i").html("&yen;"+getPrice(total,true));
        $(".total .sum i").html("&yen;"+getPrice(total,true));
    }
    // 显示更多地址
    $(document).on("click",".more a",function(){
        var t = $(this);
        t.toggleClass("on");
        if(t.hasClass("on")){
            t.html("收起地址<i></i>");
            $(".info .list").show();
        }else{
            t.html("更多地址<i></i>");
            $(".info .list:gt(0)").hide();
        }
    });

    //按合同发货
    $(document).on("click","a.htpay",function(){
        if(orderStatus != '0')
        {
            alert("请检查订单是否已支付或者已取消");
            return false;
        }
        confirmSend(orderId,0);
    });

    $(document).on("click","a.totalpay",function(){
        if(orderStatus != '0')
        {
            alert("请检查订单是否已支付或者已取消");
            return false;
        }
        payTotalMoney();
    });

    //取消订单
    $(document).on("click","a.cancel",function(){
        if(orderStatus != '0')
        {
            alert("请检查订单是否已支付或者已取消");
            return false;
        }
        window.location.href = "cancelOrder.shtml?orderId=" + orderId;
    });
    //确认收货
    $(document).on("click","a.confirmSend",function(){
        if(orderStatus != '0')
        {
            alert("请检查订单是否已支付或者已取消");
            return false;
        }
        window.location.href = "confirmOrderTake.shtml?orderId=" + orderId;
    });
})