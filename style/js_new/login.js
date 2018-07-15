/**
 * Created by lianglong on 16/1/22.
 */
var  loginPop = $(".loginPop"),
    body = $("body"),
    loginCont = $(".loginCont"),
    account = $('#account'),
    pwd = $('#pwd'),
    loginBt = $(".loginBt"),
    nullClass = $(".null"),
    loginImg = $(".loginImg");

var loginName = decodeURI(getCookie("account"));
var loginPwd = decodeURI(getCookie("pwd")),
    allLoginAccount = decodeURI(getCookie("accountNumber"));

var loginAccount = loginName,
    loginPWD = loginPwd,
    custType = null,
    custId = null,
    custGrade = null,
    custName = null;


//检查是否已经登录
checkHasLogin();
function checkHasLogin(){
    $.ajax({
        type: "GET",
        url: domain + "/member!getUserInfo.shtml",
        contentType: "text/plain; charset=utf-8",
        dataType : 'json',
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
            custName = data.XYanJ_C_Nam;

            if(custName){
                custId = data.XYanJ_C_id;
                custType = data.custType;
                custGrade = data.custGrade;
                $('.phone').html(data.XYanJ_C_Nam);
                $('.haslogin').removeClass('fn-hide');
                $('.haslogout').addClass('fn-hide');

                $('.topBlock').hide();
                /**退出登录**/
                $('.loginOut').unbind("click").click(function(){
                    logOutF();
                });              
            }
        }
    });
}

//body.click(function(){
//    loginPop.fadeOut();
//    nullClass.hide();
//});

loginCont.click(function(){
    return false;
});

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
        console.log("allLoginAccount"+allLoginAccount);
        console.log("loginPWD"+loginPWD);
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

    $.ajax({
        type:"GET",
        url:domain+"/member!ajaxLoginUser.shtml",
        data:{account:allLoginAccount,pwd:loginPWD},
        dataType : 'json',
        contentType : "text/plain; charset=utf-8",
        xhrFields:{
            withCredentials: true
        },
        success:function(data){

            if(data==""||data=="null"||data==null){
                alert("用户名或者密码错误,请重新输入");
            }else{            	
                //setTimeout(checkHasLogin,500);
                custType = data.custType;
                custId = data.XYanJ_C_id;
                console.log(custId);
                custGrade = data.custGrade;
                loginPop.fadeOut();
                $('.phone').html(data.XYanJ_C_Nam);
                window.location.reload();
                $('.haslogin').removeClass('fn-hide');
                $('.haslogout').addClass('fn-hide');
                $('.topBlock').hide();

                /**退出登录**/
                $('.loginOut').unbind("click").click(function(){
                    logOutF();
                });
            }

            /**退出登录**/
            $('.loginOut').unbind("click").click(function(){
                logOutF();
            });
        },
        error:function(){
            nullClass.html("用户名或者密码错误");
            nullClass.show();
        }
    });
}



function logOutF(){
    $.ajax({
        url:domain+'/logout.shtml',
        type: 'post',
        timeout: 10000,
        xhrFields:{
            withCredentials: true
        },
        error: function(data)
        {

            window.location.reload();
        },
        success: function(data)
        {
        	window.location.reload();
        }
    });
}

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

function getPrice(originalPrice, isFloat)
{
	console.log("parentId="+parentId);
	var defaultString="协议价";
	if(parentId != null && parentId != "" && parentId !='null')
	{
		return defaultString;
	}
	else
	{
		if(isFloat)
		{
			return parseFloat(originalPrice).toFixed(2);
		}
		else
		{
			return originalPrice
		}
		
	}
}

$(".homeRegBt").click(function(){
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

$(".center").click(function(){//我的订单

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

$(".sideNav .cz").click(function(){//鍏呭€�
    if(custId==""||custId=="null"||custId==null){
        loginPop.fadeIn();
    }else {
        window.open(domain+"/pay_confirm.jsp");
    }
    return false;
});

// 登录框
$(".loginBox .login").click(function(){
	var login = $(".login_box");
	login.fadeIn();
})
$(".loginBox .loginSupplier").click(function(){
/*    var login = $(".login_boxSupplier");
    login.fadeIn();*/
	window.open(prevdomein+"/ztrade/member/getLoginUserInfo.do");
})

$(".login_box .close").click(function(){
	var login = $(".login_box");
	login.fadeOut();
})
$(".login_boxSupplier .close").click(function(){
    var login = $(".login_boxSupplier");
    login.fadeOut();
})



$(".index").click(function(){//导航跳转首页
    window.open(prevdomein+"index.html");
});
$(".nav_btn:eq(0)").click(function(){
    window.open(prevdomein+"/business.html");
});
$(".nav_btn:eq(2)").click(function(){
    window.open(prevdomein+"/message.html");
})
