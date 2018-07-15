/**
 * Created by lianglong on 16/1/22.
 */
var  loginPop = $(".loginPop"),
    body = $(document),
    account = $('#account'),  //用户名
    pwd = $('#pwd'),  //密码
    loginBt = $(".loginBt"),   //立即登录
    nullClass = $(".null"),   //用户名密码不存在
    loginImg = $(".loginImg");
var setLoT = null,
    logOut = null;

var loginName = decodeURI(getCookie("account"));
var loginPwd = decodeURI(getCookie("pwd")),
    allLoginAccount = decodeURI(getCookie("accountNumber"));

var loginAccount = loginName,
    loginPWD = loginPwd,
    custType = null,
    custId = null,
    custGrade = null,
    custName = null;
    custParent=null;


//检查是否已经登录
// checkHasLogin();
// function checkHasLogin(){
//     $.ajax({
//         type: "GET",
//         url: domain + "/member!getUserInfo.shtml",
//         contentType: "text/plain; charset=utf-8",
//         dataType : 'json',
//         xhrFields: {
//             withCredentials: true
//         },
//         success: function (data) {
//             custName = data.XYanJ_C_Nam;
//
//             if(custName){
//                 custId = data.XYanJ_C_id;
//                 custType = data.custType;
//                 custGrade = data.custGrade;
//                 custParent = data.custParent;
//                 $('.phone').html(data.XYanJ_C_Nam);
//                 $(".haslogin").show();
//                 $(".haslogout").hide();
//                 $('.topBlock').hide();
//
//                 /**退出登录**/
//                 $('.loginOut').unbind("click").click(function(){
//                     logOutF();
//                 });
//             }
//         }
//     });
// }

// body.click(function(event){
//     console.log(",..");
//     loginPop.fadeOut();
//     nullClass.hide();
// });

loginBt.click(function(){
    checkAccount();
    return false;
});


function checkAccount(){
    if(account.val()==""||pwd.val()==""){

        nullClass.show();
    }else{
        allLoginAccount = account.val();
        loginPWD = pwd.val();
        login();
    }
}


account.focus(function(){
    nullClass.hide();
    nullClass.html("*用户名或者密码不能为空");
    document.onkeydown = function(e){
        if(e.which==13){
            checkAccount();
        }
    };

});

pwd.focus(function(){
    nullClass.hide();
    nullClass.html("*用户名或者密码不能为空");
    document.onkeydown = function(e){
        if(e.which==13){
            checkAccount();
        }
    };
});




function login(){
    var hiddenForm = new FormData();
    var form = loginBt.parents('.form');
    form.find('input,textarea,select').each(function(i){
        if (this.type=="file") {
            hiddenForm.append(this.name, this.files[0])
        }else if(this.type == 'checkbox'){
        }else if(this.type == 'radio'){
            hiddenForm.append(this.name, this.checked);
        } else {
            hiddenForm.append(this.name, this.value);
        }
    })
    loginBt.attr('disabled',true);//按钮锁定
    $.ajax({
        url  : '/user/login',
        type : "post",
        dataType : 'json',
        data : hiddenForm,
        cache: false,
        processData: false,
        contentType: false,
        success : function(response){
            s = response.status
            m = response.msg
            d = response.dom
            loginBt.removeAttr('disabled')
            if(s==200){
                // layer.open({content: json.msg ,btn: '确定'})
                alert(m)
                if (d) {
                    window.location.href = d
                } else {
                    nullClass.html("登陆成功！");
                    nullClass.show();
                    window.location.reload()
                }
            }else{
                nullClass.html(m);
                nullClass.show();
            }
        },
        error:function(){
            nullClass.html("用户名或者密码错误");
            nullClass.show();
        }
    })
    return false;
}




$(".mendianReg").click(function(){//注册
    window.open(domain+"/shopRegister.jsp");
});

$(".supplierReg").click(function(){//注册
    window.open(ztradeDomain+"/ztrade/member/toMemberRegist.do");
});

$(".loginSupplier").click(function(){//商家入驻
    window.open(ztradeDomain+"/ztrade/member/getLoginUserInfo.do");
});

/**获取cookie**/
function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}

$(".registerBt").click(function(){
    window.open(domain+"/shopRegister.jsp");
});

$(".login").click(function(){
    return false;
});

$(".close").click(function(){
    nullClass.hide();
    loginPop.fadeOut();
    return false;
});

$(".muOrderBt").click(function(){//我的订单

    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/order.shtml");
    }
    return false;
});

$(".center").click(function(){//个人中心

    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/order.shtml");
    }
    return false;
});


$(".cartBt").click(function(){//购物车
    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/skuCartInfoList.jsp");
    }
    return false;
});

$(".enquiryBt").click(function(){//我的询价单
    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/myInquiry.shtml");
    }
    return false;
});
$(".sideNav .cz").click(function(){//充值
    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/pay_confirm.jsp");
    }
    return false;
});
$(document).on("click","a.ljxd",function(){
   if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }
    return false; 
})

// 登录框
$(".loginBox .login").click(function(){
	var login = $(".login_box");
	login.fadeIn();
})


$(".login_box .close").click(function(){
	var login = $(".login_box");
	login.fadeOut();
})

$(".nav_btn:eq(1)").click(function(){//导航跳转首页
    window.open("/index.html");
});

$(".nav_btn:eq(2)").click(function(){
    window.open(prevdomein+"/message.html");
})


    function getChildPrice(price,isParse)
    {
		if(custParent != null && custParent != "")
		{
			//dom.val(defaultString);
			return defaultString;
		}
		else
		{
			if(isParse == true)
			{
				return decimal(parseFloat(price),2);
			}
			else
			{
				return price;
			}
			
		}
					
    }
    
    function decimal(num,v){
	var vv = Math.pow(10,v);
	return parseFloat(Math.round(num*vv)/vv).toFixed(2);
	}

