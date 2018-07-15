<?php
namespace Admin;
use Core\Page as Page;
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'product';
$showname = 'a-product';

//条件
$map = array();

###########################筛选开始
$id = I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$prod_brand = I('get.prod_brand','','intval');$prod_brand and $map['prod_brand'] = $prod_brand;
$prod_series = I('get.prod_series','','intval');$prod_series and $map['prod_series'] = $prod_series;
###########################筛选开始
########################分页配置开始
$psize = I('get.psize',30,'intval');
$order='disorder desc, sendtime desc, id asc';

$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => $order,
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
);
list($data,$pagestr) = Page::paging($pageConfig);
$opt = new Output;//输出流  输出表单元素
########################分页配置结束
$coustome_shape = config('custome.shape');$coustome_shape[0] = '未选择';
$coustome_style = config('custome.style');$coustome_style[0] = '未选择';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <?php include('js/head'); ?>
</head>
<body>
<div class="content clr">
    <?php Style::weizhi() ?>
    <div class="right clr">
        <form class="" id="jsSoForm">
            <!-- <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条 -->
            <!-- <b>编号</b><input name="id" type="text" class="dfinput" value="<?=$id?>"/> -->
            <?php
            $brandModel = ModelFactory('brand');
            $seriesModel = ModelFactory('brandModels');

            $opt->select2($brandModel->getField('id,brand_name', 'isstate=1'), '品牌', 'prod_brand')
            ->select2($seriesModel->getField('id,title', 'isstate=1'), '系列', 'prod_series');
            /*$d = $brandModel->getField('id,title,initials', 'isstate=1');
            $groupCate = $brandModel->getInitialsSet('id,initials', $getField=true);
            $opt
                ->groupSelect2($d, $groupCate,'品牌','brand_id', 'initials')*/
            /*
               $d2 = M('news')->where('pid=3 and ty=21')->order('disorder desc, isgood desc, id asc')->getField('id,name');Output::select2($d2,'风格','istop2');
            */ ?>
<!--            关键字<input name="title" type="text" class="dfinput" value="--><?//=$title?><!--"/>-->
            <input name="search" type="submit" class="btn" value="搜索"/></td>
        </form>
        <div class="zhengwen clr">
            <div class="zhixin clr">
                <ul class="toolbar">
                    <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
                </ul>
                <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a><!-- 刷新  -->
                <a href="<?=getUrl(array_merge(queryString(true), ['callbackEvents'=>'reload']),$showname.'_pro')?>" target="righthtml" class="newLayerWindow zhixin_a3 fl"></a><!-- 添加  -->
                <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
                <?php Style::moveback() ?>
            </div>
        </div>
        <div class="neirong clr">
            <table cellpadding="0" cellspacing="0" class="table clr">
                <tr class="first">
                    <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
                    <td width="24px">编号</td> <td width="209px">操作</td>

                    <?php
                    $opt->td('图片','系列','型号', '色号', '镜框尺寸', '鼻梁尺寸', '框型', '款式');

                    $opt->td('发布时间_|_width="104px"');
                    ?>
                </tr>
                <style>
                    td{overflow:hidden;white-space:nowrap;text-overflow:ellipsis; max-width:200px}
                </style>
                <?php
                foreach ($data as $key => $bd) : extract($bd);

                #生成修改地址
                $query = queryString(true);
                $query['id'] = $id;
                $editUrl = getUrl($query, $showname.'_pro');
                $time =  date('Y-m-d H:i',$sendtime);
                //    $img1 =  '<img src="'.src($img1).'" width="80" />';


                ?>
                <tbody>
                <tr>
                    <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
                    <td><?=$id?></td>
                    <td>
                        <a href="<?=$editUrl?>&callbackEvents=close" class="newLayerWindow">编辑</a>|
                        <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=config('webarr.isstate')[$isstate] ?></a>|
                        <!--            <a data-class="btn-danger" class="json --><?//=$isgood==1?'btn-danger':'' ?><!--" data-url="isgood&id=--><?//=$id?><!--">--><?//=config('webarr.isgood')[$isgood] ?><!--</a>|-->
                        <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
                    </td>

                    <?php

                    $opt->td(
                         '<img src="'.src($img_path).'"/>'
                        ,$prod_name
                        ,$version
                        ,$prod_color
                        ,$mirr_width
                        ,$nose_width
                        ,$coustome_shape[$shape]
                        ,$coustome_style[$style]
                    );
                    ?>

                    <td><?=$time?></td>
                </tr>
                <?php endforeach?>


                <input id="zIndexOffset" type="hidden" value="19891093">
                <script>

                    $('.newLayerWindow').click(function(){

                        href = this.href;
                        text = $(this).text();
                        var theIndex = layer.open({
                            type: 2,
                            title: text,
                            shadeClose: true,
                            anim: 1,
                            resize: true,
                            shade: false,
                            moveOut: true,
                            maxmin: true, //开启最大化最小化按钮
                            area: ['80%', '80%'],
                            content: href
                        });

                        $(this).data('layerid',theIndex);
                        return false;
                    })

                </script>
                <?php include('js/foot'); ?>
