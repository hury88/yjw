var areaDoc = null;
var provinces= null;

//解析所在区域的XML
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
function initCreate()
{
    console.log("enter initCreate");
    $('#province').empty();
    $('#province').prepend("<option value='0'>请选择省份</option>");
    $('#cities').empty();
    $('#cities').prepend("<option value='0'>请选择城市</option>");
    $('#counties').empty();
    $('#counties').prepend("<option value='0'>请选择区县</option>");
    document.getElementsByTagName("nobr")[0].innerHTML="";
    $('#con_name').val('');
    $('#telephone').val('');
    $('#street_add').val('');
    $('#fix_telephone').val('');
    $('#zip').val('');
}

function createNewAddress(isCreate,province, city, country) {
    var selectedProvince = -1;
    //点击使用新的收货地址时候才查询所在区域
    console.log("city="+city+"country="+country);
    selectedProvince = -1;
    var xmlHttp;
    if(window.ActiveXObject){
        console.log("support");
        $.ajax({
            url:'area!getAreaInfo.shtml',
            type: 'post',
            error: function()
            {
            },
            success: function(data)
            {
                //areaDoc = loadXML(data)
                areaDoc = new ActiveXObject("Microsoft.XMLDOM");
                areaDoc.async = false;
                areaDoc.loadXML(data);

                provinces = areaDoc.getElementsByTagName("Province");
                //省的SELECT
                if(isCreate)  //如果当前是创建新地址
                {
                    initCreate();
                    for (var i = 0; i < provinces.length; i++) {
                        var name = provinces[i].getAttribute("NAME");
                        $('#province').append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
                else   //如果当前是修改地址
                {
                    for (var i = 0; i < provinces.length; i++) {
                        var name = provinces[i].getAttribute("NAME");
                        if(name == province)
                        {
                            $('#province').append("<option selected value='"+name+"'>"+name+"</option>");
                            selectedProvince=  i;
                        }
                        else
                        {
                            $('#province').append("<option  value='"+name+"'>"+name+"</option>");
                        }
                    }
                    console.log("selectedProvince="+selectedProvince);
                    if(selectedProvince != -1)
                    {
                        initAddress(city,country,selectedProvince);
                    }

                }

            }
        });
    }else{
        console.log("not support");
        xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET","area!getAreaInfo.shtml");
        xmlHttp.onreadystatechange = callback;
        xmlHttp.send(null);

        function callback(){
            if(xmlHttp.readyState == 4){
                if(xmlHttp.status==200){
                    areaDoc = xmlHttp.response;
                    areaDoc = loadXML(areaDoc);
                    console.log(areaDoc)
                    provinces = areaDoc.getElementsByTagName("Province");
                    //省的SELECT
                    if(isCreate)  //如果当前是创建新地址
                    {
                        initCreate();
                        for (var i = 0; i < provinces.length; i++)
                        {
                            var name = provinces[i].getAttribute("NAME");
                            $('#province').append("<option value='"+name+"'>"+name+"</option>");
                        }
                    }
                    else   //如果当前是修改地址
                    {
                        $('#province').empty();
                        $('#province').prepend("<option value='0'>请选择城市</option>");
                        for (var i = 0; i < provinces.length; i++) {
                            var name = provinces[i].getAttribute("NAME");
                            if(name == province)
                            {
                                $('#province').append("<option selected value='"+name+"'>"+name+"</option>");
                                selectedProvince=i;
                            }
                            else
                            {
                                $('#province').append("<option  value='"+name+"'>"+name+"</option>");
                            }
                        }
                        console.log("selectedProvince="+selectedProvince);
                        if(selectedProvince != -1)
                        {
                            initAddress(city,country,selectedProvince);
                        }

                    }
                }
            }
        }
    }
}

function   (city,country,selectedProvince)
{
    //初始化province
    var selectCities = -1;
    var province = $('#province').val();
    $('#cities').empty();
    $('#cities').prepend("<option value='0'>请选择城市</option>");
    $('#counties').empty();
    $('#counties').prepend("<option value='0'>请选择区县</option>");
    if(province != "")
    {
        if(window.ActiveXObject){
            cities = areaDoc.selectNodes("//Province[@NAME='"+province+"']").nextNode().childNodes;
        }else{
            cities =  areaDoc.getElementsByTagName("Province")[selectedProvince].getElementsByTagName("City");
        }

        for (var i = 0; i < cities.length; i++) {
            var id = cities[i].getAttribute("ID");
            var name = cities[i].getAttribute("NAME");
            if(name == city)
            {
                $('#cities').append("<option selected value='"+name+"'>"+name+"</option>");
                selectCities  = i;

            }
            else
            {
                $('#cities').append("<option  value='"+name+"'>"+name+"</option>");

            }

        }
        var city = $('#cities').val();
        if(city != "" && selectCities != -1)
        {
            if(window.ActiveXObject){
                counties = areaDoc.selectNodes("//City[@NAME='"+city+"']").nextNode().childNodes;
            }else{
                counties = areaDoc.getElementsByTagName("Province")[selectedProvince].getElementsByTagName("City")[selectCities].getElementsByTagName("County");
            }
            for (var i = 0; i < counties.length; i++) {
                var name = counties[i].getAttribute("NAME");
                if(name == country)
                {
                    $('#counties').append("<option selected value='"+name+"'>"+name+"</option>");
                }
                else
                {
                    $('#counties').append("<option  value='"+name+"'>"+name+"</option>");
                }

            }
        }
        document.getElementsByTagName("nobr")[0].innerHTML = $('#province').val() + $('#cities').val() + $('#counties').val();
    }

}
var cities="";
function Province(){
    var province = $('#province').val();
    selectCities = -1;
    //清空城市和区县的数据
    $('#cities').empty();
    $('#cities').prepend("<option value='0'>请选择城市</option>");
    $('#counties').empty();
    $('#counties').prepend("<option value='0'>请选择区县</option>");
    //追加城市的列表
    if(province != ""){
        if(window.ActiveXObject){
            cities = areaDoc.selectNodes("//Province[@NAME='"+province+"']").nextNode().childNodes;
        }else{
            cities = provinces[document.getElementById("province").selectedIndex - 1].getElementsByTagName("City") ;
        }

        //市的SELECT
        for (var i = 0; i < cities.length; i++) {
            var id = cities[i].getAttribute("ID");
            var name = cities[i].getAttribute("NAME");
            $('#cities').append("<option  value='"+name+"'>"+name+"</option>");

        }
    }

    document.getElementsByTagName("nobr")[0].innerHTML = province;

}

function City(){
    var city = $('#cities').val();
    var cityValue;
    console.log("enter City");
    console.log("city="+city);
    //清空区县的数据
    $('#counties').empty();
    $('#counties').prepend("<option value='0'>请选择区县</option>");
    //追加区县的列表
    if(city != ""){
        var counties;
        if(window.ActiveXObject){
            counties = areaDoc.selectNodes("//City[@NAME='"+city+"']").nextNode().childNodes;
        }else{
            counties = cities[document.getElementById("cities").selectedIndex-1].getElementsByTagName("County") ;
        }

        //区县的SELECT
        for (var i = 0; i < counties.length; i++) {
            var name = counties[i].getAttribute("NAME");
            $('#counties').append("<option  value='"+name+"'>"+name+"</option>");

        }
        if(counties.length <= 0)
        {
            var id = cities[document.getElementById("cities").selectedIndex-1].getAttribute("ID");
            var name = cities[document.getElementById("cities").selectedIndex-1].getAttribute("NAME");

            $('#counties').append("<option value='"+name+"'>"+name+"</option>");
        }
    }

    document.getElementsByTagName("nobr")[0].innerHTML = $('#province').val() + city;
}

function County(){
    var counties = $('#counties').val();
    console.log("city html="+$('#cities').val());
    document.getElementsByTagName("nobr")[0].innerHTML = $('#province').val() + $('#cities').val() + counties;
}


//验证收货人姓名
function checkName(){
    var name = $('#con_name')[0].value;
    if(name.length < 2 || name.length > 15){
        $("#con_name_")[0].innerHTML = "请您正确填写收货人姓名";
        return false;
    }else{
        $("#con_name_")[0].innerHTML = "";
        return true;
    }
}

//验证详细地址信息
function checkStreet(){
    select = $(".validate select:last").val();
    if(select == 0){
        $("#area_").html("请您填写完整的地区信息");//  = "请您填写完整的地区信息";
        return false;
    }else{
        $("#area_")[0].innerHTML = "";
        return true;
    }


}


//	验证详细信息
function checkStreet1(){

    var street = $('#street_add').val();
    if(street.length < 5 || street.length > 60 || /^\d+$/.test(street)){
        $("#street_add_").html("请您填写收货人详细地址");
        return false;
    }else{
        $("#street_add_").html("");
        return true;
    }
}

//验证手机号码
function checkTelephone(){
    var telephone = $('#telephone')[0].value;

    var exp = new RegExp("^(13|14|15|17|18)[0-9]{9}$", "img");
    if(!exp.test(telephone)){
        $("#telephone_")[0].innerHTML = "请您填写收货人手机号码";
        return false;
    }else{
        $("#telephone_")[0].innerHTML = "";
        return true;
    }
}
//验证邮编
function checkZip(){
    var zip = $('#zip').val();

    var reg = /^[1-9]\d{5}$/g;
    return true
    /*		if(zip != "" || !reg.test(zip)){
                $("#zip_")[0].innerHTML = "邮编格式不正确";
                return false;
            }else{
                $("#zip_")[0].innerHTML = "";
                return true;
            }*/

}


//表单提交验证
function validate(){
    //验证表单是否可以提交
    if(!checkName() || !checkStreet() || !checkTelephone() || !checkZip() || !checkStreet1()){
        return false;
    }
    //异步提交表单
    return true;
}