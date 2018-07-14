$(function()
{

    $(".menu_block").mouseleave(function(event) {
        $(".s01").css({display:"none"});
        $(".s02").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s04").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub06").mouseenter(function(event) {
        $("#sub06").css({background:"#fff"});
        $(".s01").css({display:"none"});
        $(".s02").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s04").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub06").mouseleave(function(event) {
        $("#sub06").css({background:"none"});
    });

    $("#sub01").mouseenter(function(event) {
        $("#sub01").css({background:"#fff"});
        $(".s01").css({display:"block"});
        $(".s02").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s04").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub01").mouseleave(function(event) {
        $("#sub01").css({background:"none"});
    });

    $(".s01").mouseenter(function(event) {
        $("#sub01").css({background:"#fff"});
    });

    $(".s01").mouseleave(function(event) {
        $("#sub01").css({background:"none"});
        $(".s01").css({display:"none"});
    });

    $("#sub02").mouseenter(function(event) {
        $("#sub02").css({background:"#fff"});
        $(".s02").css({display:"block"});
        $(".s01").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s04").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub02").mouseleave(function(event) {
        $("#sub02").css({background:"none"});
    });

    $(".s02").mouseenter(function(event) {
        $("#sub02").css({background:"#fff"});
    });

    $(".s02").mouseleave(function(event) {
        $("#sub02").css({background:"none"});
        $(".s02").css({display:"none"});
    });

    $("#sub03").mouseenter(function(event) {
        $("#sub03").css({background:"#fff"});
        $(".s03").css({display:"block"});
        $(".s01").css({display:"none"});
        $(".s02").css({display:"none"});
        $(".s04").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub03").mouseleave(function(event) {
        $("#sub03").css({background:"none"});
    });

    $(".s03").mouseenter(function(event) {
        $("#sub03").css({background:"#fff"});
    });

    $(".s03").mouseleave(function(event) {
        $("#sub03").css({background:"none"});
        $(".s03").css({display:"none"});
    });

    $("#sub04").mouseenter(function(event) {
        $("#sub04").css({background:"#fff"});
        $(".s04").css({display:"block"});
        $(".s01").css({display:"none"});
        $(".s02").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s05").css({display:"none"});
    });

    $("#sub04").mouseleave(function(event) {
        $("#sub04").css({background:"none"});
    });

    $(".s04").mouseenter(function(event) {
        $("#sub04").css({background:"#fff"});
    });

    $(".s04").mouseleave(function(event) {
        $("#sub04").css({background:"none"});
        $(".s04").css({display:"none"});
    });

    $("#sub05").mouseenter(function(event) {
        $("#sub05").css({background:"#fff"});
        $(".s05").css({display:"block"});
        $(".s01").css({display:"none"});
        $(".s02").css({display:"none"});
        $(".s03").css({display:"none"});
        $(".s04").css({display:"none"});
    });

    $("#sub05").mouseleave(function(event) {
        $("#sub05").css({background:"none"});
    });

    $(".s05").mouseenter(function(event) {
        $("#sub05").css({background:"#fff"});
    });

    $(".s05").mouseleave(function(event) {
        $("#sub05").css({background:"none"});
        $(".s05").css({display:"none"});
    });

    $(".shop_title h1").mouseenter(function(event) {
        $(".shop_outward").slideDown(100);
    });

    $(".shop_outward").mouseleave(function(event) {
        $(".shop_outward").slideUp(100);
    });

    $("#group_rule").click(function(event) {
        $(".group_rules").slideToggle(100);
    });

    $(".list_sel_thread ul li").click(function(event) {
        $(this).parent().find('li').removeClass("se");
        $(this).parent().parent().find('.select_all').removeClass("se");
        $(this).addClass("se");
    });

    $(".select_all").click(function(event) {
        $(this).parent().find('li').removeClass("se");
        $(this).addClass("se");
    });

    $(".sales_thread").mouseenter(function(event) {
        $(this).css({border:"1px solid #eb3736"});
        $(this).find(".sales_infor").css({'backgroundColor':'#eb3736','background-image':'none'});
    });

    $(".sales_thread").mouseleave(function(event) {
        $(this).css({border:"1px solid #ccc"});
        $(this).find(".sales_infor").css({'backgroundColor':'','background-image':'url(images/bg_title.png)'});
    });

    $(".glass_channel h1").mouseenter(function(event) {
        $(".shopping_channel").slideDown(100);
    });

    $(".shopping_channel").mouseleave(function(event) {
        $(".shopping_channel").slideUp(100);
    });

    $(".shopping_list").mouseenter(function(event) {
        $(".shopping_channel").css({display:"block"});
    });

    $(".shopping_list").mouseleave(function(event) {
        $(".shopping_channel").css({display:"none"});
    });

    /*$(function(){
        var t = $("#text_box");
        $("#add").click(function(){
            t.val(parseInt(t.val())+1);
        })
        $("#min").click(function(){
            if (t.val() >= 2) {
            t.val(parseInt(t.val())-1);
        }
        })
        function setTotal(){
            $("#total").html((parseInt(t.val())*3.95).toFixed(2));
        }
        setTotal();
    })*/

    $(document).ready(function(){
        jQuery.getScript("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js", function(){
            $(".area_current h1").html(remote_ip_info.city+"市");
        });
    });

    $(".disc").click(function(event) {
        $(this).toggleClass("down");
    });

    $(".pric").click(function(event) {
        $(this).toggleClass("up");
    });

    $("#c_details").mouseleave(function(event) {
        $(this).css({display:"none"});
    });

    $(".pu1").mouseenter(function(event) {
        $(".subnav_1").css({display:"block"});
        $(".subnav_2").css({display:"none"});
    });

    $(".pu2").mouseenter(function(event) {
        $(".subnav_2").css({display:"block"});
        $(".subnav_1").css({display:"none"});
    });

    $(".nav").mouseleave(function(event) {
        $(".subnav_2").css({display:"none"});
        $(".subnav_1").css({display:"none"});
    });

    $(".nav1").mouseleave(function(event) {
        $(".subnav_2").css({display:"none"});
        $(".subnav_1").css({display:"none"});
    });

    $(".col_sele li").click(function(event) {
        $(this).parent().find('li').removeClass("scol");
        $(this).addClass("scol");
    });

});