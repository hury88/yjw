$(function(){
	
	$('#validateAccount').click(function(){
		var supplierAccount = $('#supplierAccount').val();
		if(supplierAccount.length == 0){
			alert('请填写供应商账号');
			return;
		}
		console.log(supplierAccount)
		
		$.ajax({
			url:'http://www.zyanjing.com/zyanjing/member!verifyCustAccount.shtml?cust_account='+supplierAccount,
			dataType: 'json',
			success:function(data){
				console.log(data)
				if(data.code == "-2"){
					console.log('1')
					alert('该账号不存在！')
				}else{
					$('.error').hide();
					console.log(data.cust_id)
					window.location = 'http://www.zyanjing.com/zgs_portal/forget2.html?cust_id='+data.data.cust_id+'&cust_account='+data.data.cust_account+'&cust_phone='+data.data.cust_phone;
				}
			},
			error:function(){
				
			}
			
		})
	})
	

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
	console.log(changeJson())
	var jsonStr = changeJson();
	$('.mendian').val(jsonStr['cust_account']);
	$('.idStr').val(jsonStr['cust_id']);
	$('#supplierPhone').val(jsonStr['cust_phone']);
	
	$("#getPhoneCode").click(function(){
		$("#getPhoneCode").css('outline','none');
		$("#getPhoneCode").attr('disabled',true);
		var phoneNumber = $("#supplierPhone").val();
		if(phoneNumber==""||!(/^1[34578]\d{9}$/.test(phoneNumber))){
			alert("a");
			$("#supplierPhone").prev().css("color","red");
			$("#getPhoneCode").removeAttr('disabled');
			return;
		}
		console.log(phoneNumber)
		$.ajax({
			type:"POST",
			url:'http://www.zyanjing.com/zyanjing/member!getPhoneCode.shtml',
			data: {"cust_phone" : phoneNumber},
			dataType: 'json',
			async: false,
            success: function(data){
            	console.log(data);
            	if(data.code == '0'){
            		var clickTime = new Date().getTime();
			        var Timer = setInterval(function(){
			            var nowTime = new Date().getTime();
			            var second  = Math.ceil(120-(nowTime-clickTime)/1000);
			            if(second>0){
			                $("#getPhoneCode").text(second+"s后重新获取");
			                $("#getPhoneCode").attr('disabled',true);
			                $("#getPhoneCode").css('background','#BFBFBF');
			            }else{
			            	 $("#getPhoneCode").removeAttr('disabled');
			            	 $("#getPhoneCode").css('background','#0092ff');
			            	 $("#getPhoneCode").text("获取验证码");
			                clearInterval(Timer);			               
			            }
			        },1000);
				}
            }
		});
	});
	
	$("#judgePhoneCode").click(function(){
		if($.trim($("#phoneCode").val()) == ""){
			alert("请输入手机验证码");
		}else{
			$.ajax({
				type:"POST",
				url:'http://www.zyanjing.com/zyanjing/member!judgePhoneCode.shtml',
				data:{cust_phone: $("#supplierPhone").val(),phone_code: $("#phoneCode").val()},
				dataType: 'json',
				async: false,
				success: function(data){
					console.log(data);
					if(data.code == 0){
						console.log('1')
						console.log($('.idStr').val())
						window.location = 'http://www.zyanjing.com/zgs_portal/forget3.html?cust_id='+$('.idStr').val()
					}else{					
						alert(data.msg);
					}											
				}
			});	
		}					
	});
	
	$("#confirmModifyPwd").click(function(){
		if($.trim($("#newPassword").val()) == ''){
			$("#newPassword").prev().css('color', 'red');
		}else if($.trim($("#confirmPassword").val()) == ''){
			$("#confirmPassword").prev().css('color', 'red');
		}else if($.trim($("#newPassword").val()) != $.trim($("#confirmPassword").val())){
			alert("两次密码填写不一致,请重新填写");
			$("#newPassword").val('');
			$("#confirmPassword").val('');
		}else{
			$.ajax({
				type:"POST",
				url:'http://www.zyanjing.com/zyanjing/member!updateCustPwd.shtml?cust_id='+jsonStr.cust_id+'&cust_pwd='+$("#newPassword").val(),
				dataType: 'json',
				async: false,
				success: function(data){
					console.log(data);
					if(data.code == 0){
						window.location = 'http://www.zyanjing.com/zgs_portal/forget4.html'
					}else{					
						alert(data.msg);
					}											
				}
			});	
		}
	});
	
})