@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="/style/css/base.css">
    <link href="/style/css/background.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/style/css/myinfo.css">
    <script src="/style/js/jquery-1.9.0.js"></script>
    <script type="text/javascript" src="/style/js/jquery.blockui.js"></script>
    <script>

        var areaDoc = null;
        var provinces = null;

        var imgSub = false;

        var xmlHttp;


        loadXML = function(xmlString){
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

        /* 	}else {
                xmlHttp = new XMLHttpRequest();

                xmlHttp.open("GET","area!getAreaInfo.shtml");
                xmlHttp.onreadystatechange = callback;
                xmlHttp.send(null);

                function callback(){
                    if(xmlHttp.readyState == 4){
                        if(xmlHttp.status==200){
                            areaDoc = xmlHttp.responseXML;
                             provinces = areaDoc.getElementsByTagName("Province");
                             //省的SELECT
                             for (var i = 0; i < provinces.length; i++) {
                                  var name = provinces[i].getAttribute("NAME");
                                  var id = provinces[i].getAttribute("ID");
                                  $('#province').append("<option value='"+id+"'>"+name+"</option>");
                             }
                        }
                    }
                }
            } */



        if("" !=""){
            $.unblockUI({ message: $('.overlay') });
            alert("注册完成，请等待管理人员审核...");
            window.location.href="/";
        }

        if("" !=""){
            alert("请上传小于4M的扫描件");
        }


        function setRed(field){
            document.getElementById(field).color = "red";
        }

        function setGreen(field){
            document.getElementById(field).color = "green";
        }

        var flag = false;

        var cities;
        function Province(){
            var province = $('#province').val();
            //清空城市和区县的数据
            $('#cities').empty();
            $('#cities').prepend("<option value=''>请选择城市</option>");
            $('#areas').empty();
            $('#areas').prepend("<option value=''>请选择区/县</option>");



            //追加城市的列表
            //if(province != ""){



            //var cities = areaDoc.getElementById(province).nextNode().childNodes;
            if(provinces[document.getElementById("province").selectedIndex-1]){
                if(window.ActiveXObject){
                    cities = areaDoc.selectNodes("//Province[@ID='"+province+"']").nextNode().childNodes;
                }else{
                    //console.log( provinces[document.getElementById("province").selectedIndex-1]);
                    cities = provinces[document.getElementById("province").selectedIndex-1].getElementsByTagName("City") ;
                }
            }

            if(cities){
                //市的SELECT
                for (var i = 0; i < cities.length; i++) {
                    var name = cities[i].getAttribute("NAME");
                    var id = cities[i].getAttribute("ID");
                    $('#cities').append("<option value='"+id+"'>"+name+"</option>");
                }
            }
            //}

            //document.getElementsByTagName("nobr")[0].innerHTML = province;

        }

        function City(){
            var city = $('#cities').val();
            var cityValue;
            //清空区县的数据
            $('#areas').empty();
            $('#areas').prepend("<option value=''>请选择区/县</option>");
            //追加区县的列表
            if(city != ""){


                var counties;
                if(window.ActiveXObject){
                    counties = areaDoc.selectNodes("//City[@ID='"+city+"']").nextNode().childNodes;
                }else{
                    counties = cities[document.getElementById("cities").selectedIndex-1].getElementsByTagName("County") ;
                }

                //区县的SELECT
                for (var i = 0; i < counties.length; i++) {
                    var name = counties[i].getAttribute("NAME");
                    var id =  counties[i].getAttribute("ID");
                    $('#areas').append("<option value='"+id+"'>"+name+"</option>");
                }

                if(counties.length <= 0)
                {

                    if(cities){
                        //市的SELECT
                        for (var i = 0; i < cities.length; i++) {
                            var name = cities[i].getAttribute("NAME");
                            var id = cities[i].getAttribute("ID");
                            if(id == city )
                            {
                                cityValue =  name;
                                break;
                            }
                        }
                    }
                    $('#areas').append("<option value='"+city+"'>"+cityValue+"</option>");
                }
            }
            $("#address_")[0].innerHTML ="*";
            setRed("address_");
            //document.getElementsByTagName("nobr")[0].innerHTML = $('#province').val() + cities;
        }
        function Area(){
            if(""==$('#areas').val()){
                $("#address_")[0].innerHTML ="*";
                setRed("address_");
                return;
            }
            $("#address_")[0].innerHTML = "√ 可以注册";
            setGreen("address_");

        }


        /*function checkAccount(){
            var name = $("#account")[0].value;
            if(name == "" || name == null || name.length < 3){
                $("#cust_account_")[0].innerHTML = "- 登录账号长度不能少于 3 个字符";
                setRed("cust_account_");
                return false;
            }

            //ajax校验用户名是否存在
            $.ajax({
                url:'member!validationRegiSter.shtml',
                type: 'post',
                data: {"paramName":"cust_account","param":name},
                timeout: 10000,
                error: function()
                {
                    alert('操作失败!');
                },
                success: function(data)
                {
                    if(data == "1"){
                        $("#cust_account_")[0].innerHTML = "- 该账号已经存在,请重新输入";
                        setRed("cust_account_");
                        flag = false;
                        return false;
                    }
                    if(data == "0"){
                        $("#cust_account_")[0].innerHTML = "√ 可以注册";
                        setGreen("cust_account_");
                        flag = true;
                        return true;
                    }
                }
            });

            return true;
        }*/

        function checkName(){
            var name = $("#cust_name")[0].value;
            if(name == "" || name == null){
                $("#cust_name_")[0].innerHTML = "- 用户名称为必填项";
                setRed("cust_name_");
                return false;
            }

            $("#cust_name_")[0].innerHTML = "√ 可以注册";
            setGreen("cust_name_");
            return true;
        }

        var flag_ = false;

        function checkPerson(){
            var person =$("#cust_legal_person")[0].value;
            if(person == "" || person == null){
                $("#cust_legal_person_")[0].innerHTML = "- 法人名称不能为空";
                setRed("cust_legal_person_");
                return false;
            }
            $("#cust_legal_person_")[0].innerHTML = "√ 可以注册";
            setGreen("cust_legal_person_");
            return true;
        }

        function checkPhone(){
            var phone =$("#cust_phone")[0].value;
            if(phone == "" || phone == null){
                $("#cust_phone_")[0].innerHTML = "- 手机号不能为空";
                setRed("cust_phone_");
                return false;
            }else if(!isDigit(phone)){
                $("#cust_phone_")[0].innerHTML = "- 手机号格式不正确";
                setRed("cust_phone_");
                return false;
            }
            $("#cust_phone_")[0].innerHTML = "√ 可以注册";
            setGreen("cust_phone_");
            return true;
        }
        //手机号格式验证
        function isDigit(s)
        {
            var patrn=/^((\+86)|(86))?(1)\d{10}$/;
            if (!patrn.exec(s)) return false
            return true
        }

        //验证上传图片
        function checkPhoto(fileName,fileSize,that){

            var photo=$('#'+fileName)[0].value;
            var lastName=photo.substring(photo.lastIndexOf(".")+1,photo.length);
            if(("jpg"==lastName || "gif"==lastName || "bmp"==lastName || "png"==lastName || "jpeg"==lastName)&&fileSize<=4096000){
                $("#"+fileName+"_")[0].innerHTML = "√ 可以注册";
                setGreen(fileName+"_");
                that.removeAttribute("imgSub");
            }else{
                if(fileSize>4096000){
                    $("#"+fileName+"_")[0].innerHTML = "";
                    that.setAttribute("imgSub","false");
                    alert("文件大于4M，请选择合适的图片重新上传！");
                    return false;
                }

                if (document.getElementById(fileName).outerHTML) {
                    document.getElementById(fileName).outerHTML = document.getElementById(fileName).outerHTML;
                } else {
                    document.getElementById(fileName).value = "";
                }


                //person_file企业法人身份证扫描件
                //license_file营业执照扫描件
                //other_file组织机构代码扫描件
                if("person_file"==fileName){
                    //alert("企业法人身份证扫描件格式不正确");
                    $("#"+fileName+"_")[0].innerHTML = "- 企业法人身份证扫描件格式不正确";
                    setRed(fileName+"_");
                    return false;
                }else if("license_file"==fileName){
                    //alert("营业执照扫描件格式不正确");
                    $("#"+fileName+"_")[0].innerHTML = "- 营业执照扫描件格式不正确";
                    setRed(fileName+"_");
                    return false;
                }else if("other_file"==fileName){
                    //alert("组织机构代码扫描件格式不正确");
                    $("#"+fileName+"_")[0].innerHTML = "- 组织机构代码扫描件格式不正确";
                    setRed(fileName+"_");
                    return false;
                }
            }
        }



        /*function checkPassword(){
            var reg = /^[a-zA-Z0-9]{6,20}$/g;
            var pwd = $("#pwd")[0].value;
            if(pwd == "" || pwd == null || !reg.test(pwd)){
                $("#cust_pwd_")[0].innerHTML = "- 密码请设为6-20位字母或数字";
                setRed("cust_pwd_");
                return false;
            }

            $("#cust_pwd_")[0].innerHTML = "√ 可以注册";
            setGreen("cust_pwd_");
            return true;
        }

        function checkRePassword(){
            var reg = /^[a-zA-Z0-9]{6,20}$/g;
            var re_pwd = $("#re_pwd")[0].value;
            if(re_pwd == "" || re_pwd == null || !reg.test(re_pwd)){
                $("#re_cust_pwd_")[0].innerHTML = "- 密码请设为6-20位字母或数字";
                setRed("re_cust_pwd_");
                return false;
            }

            var pwd = $("#pwd")[0].value;

            if(re_pwd != pwd){
                $("#re_cust_pwd_")[0].innerHTML = "- 两次输入密码不一致";
                setRed("re_cust_pwd_");
                return false;
            }

            $("#re_cust_pwd_")[0].innerHTML = "√ 可以注册";
            setGreen("re_cust_pwd_");
            return true;
        }*/

        function check(){
            if(!$("#checkbox")[0].checked) alert("您没有接受协议");

            return $("#checkbox")[0].checked;
        }

        function validate(){
            //验证
            /*var name = $("#account")[0].value;
            if(name == "" || name == null || name.length < 3){
                //alert("cusName");
                $("#cust_account_")[0].innerHTML = "- 登录账号长度不能少于 3 个字符";
                setRed("cust_account_");
                return false;
            }*/

            $(".llimg").each(function(){

                if($(this).attr("imgSub")==false||$(this).attr("imgSub")=="false"){
                    imgSub = true;
                }
            });

            if(!checkName()) return false;

            if(imgSub == true){
                alert("图片大于4M或未选择图片，请重新提交！");
                imgSub = false;
                return false;
            }

            var email = $("#cust_email")[0].value;
            /*if(email == "" || email == null){
                $("#cust_email_")[0].innerHTML = "- 邮件地址不能为空";
                setRed("cust_email_");
                return false;
            }*/
            var province =$("#province")[0].value;
            if(province == "" || province == null){
                $("#address_")[0].innerHTML = "- 地址不能为空";
                setRed("address_");
                return false;
            }
            var cityInfo =$("#cities")[0].value;
            if(cityInfo == "" || cityInfo == null){
                $("#address_")[0].innerHTML = "- 地址不能为空";
                setRed("address_");
                return false;
            }
            var areasInfo =$("#areas")[0].value;
            if(areasInfo == "" || areasInfo == null){
                $("#address_")[0].innerHTML = "- 地址不能为空";
                setRed("address_");
                return false;
            }
            if(!checkPerson()) {return false;}
            if(!checkPhone()) {return false;}
            /*var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if(!reg.test(email)){
                $("#cust_email_")[0].innerHTML = "- 邮件地址不合法";
                setRed("cust_email_");
                return false;
            }*/

            //验证表单是否可以提交
            if(!check()){
                return false;
            }
            //异步提交注册表单
            var hiddenForm = new FormData();
            var form = $("#member_0").parents('.form');
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
            $("#member_0").attr('disabled',true);//按钮锁定
            $.ajax({
                url  : '/user/register',
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
                    $("#member_0").removeAttr('disabled')
                    if(s==200){
                        // layer.open({content: json.msg ,btn: '确定'})
                        alert(m)
                        if (d) {
                            window.location.href = d
                        } else {
                            window.location.reload()
                        }
                    }else{
                        alert(m);
                        form.find("input[name="+d+"]").focus()
                    }
                },
                error : function(){
                    $("#member_0").removeAttr('disabled');
                    alert('请按照提示操作, 以获得更好的服务');
                }
            })
            return false;
        }


    </script>
    <link rel="stylesheet" href="/style/css/style.css" type="text/css">

@stop
@section('wapper')

    <!-- 面包屑 -->
<div class="main">
    <div class="bread"><a href="/">首页 </a> > >在线注册申请</div>
    <div class="content">
        <div class="right">
            <div class="titlegray">在线注册申请</div>
            <form id="member" class="form" name="member"  action="/user/register" method="post" enctype="multipart/form-data">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="biaoge2">
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">公司</td>
                        <td align="left" >
                            <input type="text" name="username" maxlength="20" value="" id="cust_name" class="address_input" onblur="checkName()"/>
                            <font id="cust_name_" color="red" align="left">
                                *
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#f0f0f0">所在地区</td>
                        <td align="left" >
                            <select name="z_1" id="province" onchange="Province()" class="province">
                                <option value="2">请选择省份</option>
                            </select>
                            <select name="z_11" id="cities" class="cities" onchange="City()">
                                <option value="3">请选择城市</option>
                            </select>
                            <select name="z_12" id="areas" onchange="Area()">
                                <option value="4">请选区/县</option>
                            </select>
                            <input type="text" name="z_13" maxlength="400" value="" id="street_add" style="width:60%;height:20px; border:1px solid #ccc;margin-top:1px"/>

                            <font color="red" id="address_">*</font>

                        </td>
                    </tr>

                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">法人</td>
                        <td align="left" >
                            <input type="text" name="z_2" maxlength="25" value="" id="cust_legal_person" class="address_input" onblur="checkPerson()"/>
                            <font id="cust_legal_person_" color="red" align="left">
                                *
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">手机</td>
                        <td align="left" >
                            <input type="text" name="z_3" maxlength="25" value="" id="cust_phone" class="address_input" onblur="checkPhone()"/>
                            <font id="cust_phone_" color="red" align="left">
                                *
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">联系人</td>
                        <td align="left" >
                            <input type="text" name="z_4" maxlength="25" value="" id="cust_person" class="address_input"/>

                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">固定电话</td>
                        <td align="left" >
                            <input type="text" name="z_5" maxlength="25" value="" id="cust_tel" class="address_input"/>

                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">电子邮箱</td>
                        <td align="left" >
                            <input type="text" name="z_6" maxlength="25" value="" id="cust_email" class="address_input"/>
                            <font id="cust_email_" color="red" align="left">

                            </font>
                        </td>
                    </tr>

                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">请上传企业法人身份证扫描件。<br>证件照为jpg|bmp|png格式，大小不超过4MB</td>
                        <td align="left" >
                            <input type="file" name="z_7" value="" id="person_file" class="address_input llimg" onchange="checkPhoto('person_file',this.files[0].size,this)"/>
                            <font id="person_file_" color="red" align="left"></font>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">请上传营业执照扫描件。<br>证件照为jpg|bmp|png格式，大小不超过4MB</td>
                        <td align="left" >
                            <input type="file" name="z_8" value="" id="license_file" class="address_input llimg" onchange="checkPhoto('license_file',this.files[0].size,this)"/>
                            <font id="license_file_" color="red" align="left"></font>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" align="right" bgcolor="#f0f0f0">请上传组织机构代码扫描件。<br>证件照为jpg|bmp|png格式，大小不超过4MB</td>
                        <td align="left" >
                            <input type="file" name="z_9" value="" id="other_file" class="address_input llimg" onchange="checkPhoto('other_file',this.files[0].size,this)"/>
                            <font id="other_file_" color="red" align="left"></font>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" bgcolor="#f0f0f0"></td>
                        <td align="left" >
                            <input id="checkbox" checked="true" type="checkbox" name="checkbox" id="checkbox" />    已阅读并同意<span class="g_blue"><a href="regagreement.jsp" target="_parent">《注册协议》</a></span></td>
                    </tr>
                </table>

                <p class="g_tc"><input type="submit" onclick="return validate();" id="member_0" value="&#27880;&#20876;" class="modify_input"/>

                    <input type="button" value="取消" class="modify_input" onclick="history.go(-1)"/></p>

            </form>





        </div>
    </div>

</div>

<div class="overlay" style="padding-left: 25%;padding-top: 30%;display:none;">
    <img src="/style/images/loading.gif" alt="">
</div>
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/style/js/jquery.min.js"></script>
    <script src="/style/js/jquery.SuperSlide.2.1.1.js"></script>
    <script type="text/javascript" src="/style/js/Marquee.js"></script>
    <script src="/style/js/main.js"></script>
    <script src="/style/js/login.js"></script>

    <script type="text/javascript" src="/style/js/homeajax.js"></script>
    <script src="/style/js/allSearch.js"></script> 
    @stop