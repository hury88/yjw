$(function(){
    var cartList =  $('.con');
    getCartList();
    function getCartList()
    {
        var cartHtml="";
        $.ajax({
            type:"POST",
            url:""+domain+"/cart!getSkuCartList.shtml",
            dataType : 'json',
            contentType : "text/plain; charset=utf-8",
            success:function(data){
                if(data != null)
                {
                    console.log(data.length);
                    for(var index=0; index < data.length; index++)
                    {
                        var tmpObj = data[index];

                        if(tmpObj.sku_prod_list != null && tmpObj.sku_prod_list.length > 0)
                        {
                            var cartHtml ='<div class="list_con">'+
                                '<div class="fahuofang fn-clear" style="height:50px; line-height:50px; font-size:14px;border-top:1px solid #CCC">'+
                                '<input class="checkbox fn-left" type="checkbox" >'+
                                '<span class="fn-left supper" style="margin-left:20px;">发货方：<em>'+tmpObj.supplier_name+'</em></span>'+
                                '<span class="fn-right heji" style="margin-right:20px;">合计：<em></em></span></div>';
                            for(var i=0; i < tmpObj.sku_prod_list.length; i++)
                            {
                                var obj = tmpObj.sku_prod_list[i]
                                if(obj.prod_type == "0" || obj.prod_type == "6")
                                {
                                    cartHtml+='<div class="list">'+
                                        '<ul class="good single fn-clear" prod_id="'+obj.prod_id+'"prod_type="'+obj.prod_type+'"prod_name="'+obj.prod_name+'"prod_brand="'+obj.prod_brand+'"supplier_id="'+obj.relation_whole_id+'"prod_brand="'+obj.prod_brand+'"price="'+obj.price+
                                        '"cart_id="'+obj.cart_id+'"used_discount="'+obj.discount+'"original_total_price="'+obj.total_sku_price+'"quality="'+obj.total_sku_quanlity+'"img_path="'+obj.img_path+'"prod_series="'+obj.prod_series+'"lens_type="'+obj.lens_type+'"isfix="'+obj.isfix+'">'+
                                        '<li class="b8"><input class="checkbox" name="prod_check" type="checkbox"></li>'+
                                        '<li class="b44">';
                                    if(obj.img_path != null && obj.img_path != '')
                                    {
                                        cartHtml+='<img class="fn-left" src="'+obj.img_path+'" alt="">';
                                    }
                                    else
                                    {
                                        cartHtml+='<img class="fn-left" src="newcs/img/glassStatic.jpg" alt="">';
                                    }
                                    cartHtml+='<span class="fn-left prod_name">'+obj.prod_name+'</span>'+
                                        '</li>'+
                                        '<li class="b12 num">'+obj.total_sku_quanlity+'</li>';
                                    /*	               					 if(parentId != null && parentId != "")
                                                                         {
                                                                                cartHtml+='<li class="b12"><span class="mon">&yen;'+defaultString+'</span></li>';
                                                                         }
                                                                         else
                                                                         {
                                                                             cartHtml+='<li class="b12"><span class="mon money">&yen;'+parseFloat(obj.total_sku_price).toFixed(2)+'</span></li>';
                                                                         }*/
                                    cartHtml+='<li class="b12"><span class="mon money">&yen;'+getPrice(obj.total_sku_price,true)+'</span></li>';
                                    cartHtml+='<li class="b12">'+obj.supplier_name+'</li>'+
                                        '<li class="b12 none"><a href="javascript:;" class="delete">删除</a><a class="revise" onclick="modify(this)">修改</a></li><ul>'+
                                        '</div>';
                                }
                                else
                                {
                                    cartHtml+='<div class="list"><ul class="good fn-clear" prod_id="'+obj.prod_id+'"prod_type="'+obj.prod_type+'"prod_name="'+obj.prod_name+'"prod_brand="'+obj.prod_brand+'"supplier_id="'+obj.relation_whole_id+'"price="'+obj.price+
                                        '"cart_id="'+obj.cart_id+'"used_discount="'+obj.discount+'"original_total_price="'+obj.total_price+'"quality="'+obj.quantity+'"img_path="'+obj.img_path+'"prod_series="'+obj.prod_series+'"isfix="'+obj.isfix+'">'+
                                        '<li class="b8"><input class="checkbox" name="prod_check" type="checkbox"></li>'+
                                        '<li class="b44">'+
                                        '<img class="fn-left" src="'+obj.img_path+'" alt="">'+
                                        '<span class="fn-left prod_name">'+obj.prod_name+'</span>'+
                                        '</li>'+
                                        '<li class="b12"><p><i class="minus">-</i>'+
                                        '<input type="text" class="inputnum" value="'+obj.quantity+'">'+
                                        '<i class="plus">+</i>'+
                                        '</p>'+
                                        '</li>';
                                    /*                					 if(parentId != null && parentId != "")
                                                                         {
                                                                             cartHtml+='<li class="b12"><span class="mon">&yen;'+defaultString+'</span></li>';
                                                                         }
                                                                         else
                                                                         {

                                                                             cartHtml+='<li class="b12"><span class="mon">&yen;'+parseFloat(obj.total_price).toFixed(2)+'</span></li>';
                                                                         } */
                                    cartHtml+='<li class="b12"><span class="mon">&yen;'+getPrice(obj.total_price,true)+'</span></li>';
                                    cartHtml+='<li class="b12">'+obj.supplier_name+'</li>'+
                                        '<li class="b12 none"><a href="javascript:;" class="delete">删除</a></li>'+
                                        '</ul></div>';
                                }
                            }
                            cartHtml+="</div>";
                        }
                        cartList.append(cartHtml);
                    }
                    registerClick();
                }
            }

        });
    }

    function registerClick()
    {
        //全选按钮默认不选中
        $(".total input").attr("checked",false);
        $(".list_con").each(function(){
            console.log("lala");
            getSupplierMonent(this);
        })

        // 全选
        $(".total input").click(function(){
            var $this = $(this);
            if($this.attr("checked") == "checked"){
                $(".list .checkbox").attr("checked",true);
                $(".fahuofang .checkbox").attr("checked",true);
                total();
            }else{
                $(".list .checkbox").attr("checked",false);
                $(".fahuofang .checkbox").attr("checked",false);
                number.html("0");
                sum.html("0");
            }
        })


        // 单个系列选择
        $(".all_goods .checkbox").click(function(){
            var t = $(this), all_goods = t.closest(".all_goods"),
                checkbox = all_goods.siblings(".goods").find(".checkbox");
            if(t.attr("checked") == "checked"){
                checkbox.attr("checked",true);
            }else{
                checkbox.attr("checked",false);
            }
            total();
            allselect()
        })

        // 单个商品选择
        $(".good .checkbox").click(function(){
            var t = $(this), mygoods = t.closest(".goods"),
                box = mygoods.siblings(".all_goods").find(".checkbox"),
                l = mygoods.find("ul").length;
            if(mygoods.find(":checked").length == l){
                box.attr("checked",true);
            }else{
                box.attr("checked",false);
            }
            allselect()
            total();
        })

        // 数量加
        $("i.plus").click(function(){
            updateFrameProd(this,1);
        })
        // 数量减
        $("i.minus").click(function(){
            updateFrameProd(this,0);
        })

        //input 输入框
        $("input.inputnum").keyup(function(){
            this.value = this.value.replace(/[^\d]/g,'1');
            updateFrameProd(this,2);
        })
        function updateFrameProd(tThis, plus){
            var t = $(tThis), input = t.siblings("input");
            console.log("val="+input.val());
            var val = parseInt(input.val());
            //获取属性值
            var ul = $(tThis).parent().parent().parent();
            var listCon =ul.parent().parent();
            var prod_id = ul.attr("prod_id");
            var prod_price = ul.attr("price");
            var cart_id = ul.attr("cart_id");
            var supplier_id = ul.attr("supplier_id");
            var used_discount = ul.attr("used_discount");
            var dj = ul.attr("price");
            if(plus == 1)
                val++;
            else if(plus == 0)
            {
                if(val>1){
                    val--;
                }
            }
            else  if(plus == 2)
            {
                val = parseInt(t.val());
            }
            if(!isNaN(val))
            {
                $.ajax({
                    url:'cart!updateElseProd.shtml',
                    type: 'post',
                    data: {"cart_id":cart_id,"price":prod_price,"quantity":val,"prod_id":prod_id,"supplier_id":supplier_id,"discount":used_discount},
                    timeout: 10000,
                    error: function()
                    {
                        alert('操作失败!');
                    },
                    success: function(data)
                    {
                        var allp = (dj*val).toFixed(2);
                        /*						if(parentId != null && parentId != "")
                                                {
                                                    ul.closest(".good").find(".mon").html("￥"+defaultString);
                                                }
                                                else
                                                {
                                                    ul.closest(".good").find(".mon").html("￥"+allp);
                                                }*/
                        ul.closest(".good").find(".mon").html("￥"+getPrice(allp));
                        getSupplierMonent(listCon);
                        input.val(val);
                        ul.attr("quality",val);
                        ul.attr("original_total_price",allp);
                        load();
                        total();
                    }
                })
            }
        }

        $(".good .delete").click(function(){
            var cartId =  $(this).parent().parent().attr("cart_id");
            deleteCart(cartId);
        })
    }

    var len = $(".list_con ul").length;
    // 当页面刷新的时候显示的数量和价格
    function load(){
        $(".all_goods").each(function(){
            var t = $(this), num = t.find(".num"), mon = t.find(".mon"), alln = 0, allm = 0;
            t.siblings(".goods").find(".good").each(function(){
                var $t = $(this), single = parseInt($t.find("p input").val());
                if(!isNaN(parseInt(single)))
                    alln += single;
                var money = parseFloat($t.find(".mon").html().substr(1));
                allm += money;

            })
            allm = allm.toFixed(2);
            num.html(alln);

        })
    }

    // 计算总价格和总数量
    var number = $(".total span.num em"),
        sum = $(".total span.sum em");
    function total(){
        var all_num = 0, all_mon = 0;
        // 总数量
        $(".good .num").each(function(){
            var t = $(this), good = t.closest(".good");
            if(good.find(".checkbox").attr("checked") == "checked"){
                var single = parseInt(t.html())
            }else{
                single = 0;
            }
            all_num += single;

        })
        $(".good p input").each(function(){
            var t = $(this),good = t.closest(".good");
            if(good.find(".checkbox").attr("checked") == "checked"){
                var single = parseInt(t.val())
            }else{
                single = 0;
            }
            all_num += single;

        })
        number.html(all_num);
        // 总价格
        $(".good .mon").each(function(){
            var t = $(this),good = t.closest(".good");
            if(good.find(".checkbox").attr("checked") == "checked"){
                var single = parseFloat(t.html().substr(1));
            }else{
                single = 0;
            }
            all_mon += single;
        })
        all_mon = all_mon.toFixed(2);
        /*		if(parentId != null  && parentId !="")
                {
                    sum.html(defaultString);
                }
                else
                {
                    sum.html(all_mon);
                }*/
        sum.html(getPrice(all_mon,true));
    }

    // 获取某一个供货方的总金额
    function getSupplierMonent(listCon)
    {
        var totalMon=0;
        $(listCon).find(".list").each(function(){
            var mon = $(this).find("ul li span.mon").html().substr(1);
            totalMon += parseFloat(mon);
        });
        /*		if(parentId != null  && parentId !="")
                {
                    $(listCon).find("span.heji em").html("￥"+defaultString);
                }
                else
                {
                    $(listCon).find("span.heji em").html("￥"+parseFloat(totalMon).toFixed(2));
                }*/
        $(listCon).find("span.heji em").html("￥"+getPrice(totalMon,true));

    }

    // 删除
    function allselect(){
        var no = $(".list_con ul").length;
        if($(".list_con").find(":checked").length == no){
            $(".total input").attr("checked",true);
        }else{
            $(".total input").attr("checked",false);
        }
    }

//	继续购物
    $(".shopping").click(function(){
        window.location.href = prevdomein+'index.html';
    })

    $(document).on("click",".prod_name",function(){
        var t =$(this).parent().parent();
        if(t.attr("prod_type") == "0")
        {
            var url= prevdomein+"jpSelect.html?"+t.attr("prod_brand")+"="+t.attr("prod_name");
            window.open(url);
        }
        else
        {
            var url= prevdomein+"jjSelect.html?"+t.attr("prod_brand")+"%"+t.attr("prod_type");
            window.open(url);
        }

    })

    // 供货商全选
    $(document).on("click",".fahuofang input",function(){
        console.log("click");
        var $this = $(this);
        if($this.attr("checked") == "checked"){
            $this.parent().siblings(".list").each(function(){
                $(this).find("input[name='prod_check']").attr("checked",true);
            });
            total();
        }else{
            $this.parent().siblings(".list").each(function(){
                $(this).find("input[name='prod_check']").attr("checked",false);
            });
            total();
        }
    })

})