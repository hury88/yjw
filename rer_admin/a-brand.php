<?php
namespace Admin;
use Core\Page as Page;
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'brand';
$showname = 'a-brand';

$typeSet = array(
    '29' => 0,//镜片
    '30' => 4,//镜架
    '31' => 7,//太阳镜
    '32' => 6,//功能眼镜
    '33' => 2,//其他
);
$type_value = isset($typeSet[$ty]) ? $typeSet[$ty] : -1;

//条件
$map = array('type_value' => $type_value);

###########################筛选开始
$id    =   I('get.id','','trim');if(!empty($id))$map['id'] = array('like',"%$id%");
$brand_name =   I('get.brand_name','','trim');if(!empty($brand_name))$map['brand_name'] = array('like',"%$brand_name%");
// $istop2 =  I('get.istop2',0,'intval');if(!empty($istop2))$map['istop2'] = $istop2;
###########################筛选结束
###########################排序开始
$order=array();
$orderString = '';

$orderValue = I('get.orderValue','','trim'); $orderStyle = I('get.orderStyle','','trim');
if(!empty($orderValue))$order[$orderValue] = $orderStyle;

$order['id']='desc';
foreach ($order as $ok => $ov) {
  $orderString .= "$ok $ov,";
}
$orderString = rtrim($orderString,',');
###########################排序结束
########################分页配置开始
$psize   =   I('get.psize',30,'intval');

$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => $orderString,
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
    );
list($data,$pagestr) = Page::paging($pageConfig);
$opt = new Output;//输出流  输出表单元素
########################分页配置结束
// _SQL();
$query = queryString(true);
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
            /*$InitialsSet = ModelFactory('brand')->getInitialsSet('id,initials', $getField=true);
            $query = queryString(true);
            $query['initials'] = '';
            echo '<a class="initials" href="'.getUrl($query, $showname).'">全部</a>';
            foreach ($InitialsSet as $key => $value) {

                $query['initials'] = $value;
                $url = getUrl($query, $showname);

                echo '<a class="initials" href="'.$url.'">'.$value.'</a>';

            }
            unset($query['initials']);
        */
        /*
       $d2 = M('news')->where('pid=3 and ty=21')->order('disorder desc, isgood desc, id asc')->getField('id,title');Output::select2($d2,'风格','istop2');
    */ ?>
        关键字<input name="brand_name" type="text" class="dfinput" value="<?=$brand_name?>"/>
        <input name="search" type="submit" class="btn" value="搜索"/></td>
    </form>
    <div class="zhengwen clr">
      <div class="zhixin clr">
        <ul class="toolbar">
            <li>&nbsp;<input style="display:none" type="checkbox"><i id="sall" class="alls" onclick="selectAll(this)">&nbsp;</i><label style="cursor:pointer;font-size:9px" onclick="selectAll(document.getElementById('sall'))" for="">全选</label></li></li>
        </ul>
        <a href="javascript:window.location.reload();" class="zhixin_a2 fl"></a><!-- 刷新  -->
        <a href="<?=getUrl(array_merge($query, ['type_value'=>$type_value]), $showname.'_pro')?>" target="righthtml" class="zhixin_a3 fl"></a><!-- 添加  -->
        <input id="del" type="button" class="zhixin_a4 fl"/><!-- 删除  -->
        <?php Style::moveback() ?>
</div>
</div>
<div class="neirong clr">
    <table cellpadding="0" cellspacing="0" class="table clr">
       <tr class="first">
        <td onclick="selectAll(document.getElementById('sall'))" style="font-size:8px;cursor:pointer" width="24px">全选</td>
        <td width="24px">编号</td> <td>操作</td>

    <?php
        $opt->td('LOGO', '配图'
            ,'品牌名&nbsp;&nbsp;<a href="'.getUrl(array_merge($query, ['orderValue'=>'brand_name','orderStyle'=>'desc']), $showname).'">↑</a>&nbsp;&nbsp;<a href="'.getUrl(array_merge($query, ['orderValue'=>'brand_name','orderStyle'=>'asc']), $showname).'">↓</a>'
        );

        $opt->td('发布时间_|_width="104px"');
     ?>
</tr>
<?php
    foreach ($data as $key => $bd) : extract($bd);

    #生成修改地址
    $query = queryString(true);
    $query['id'] = $id;
    $editUrl = getUrl($query, $showname.'_pro');
    $time =  date('Y-m-d H:i',$sendtime);

    $img1 =  '<img src="'.src($brand_image).'" width="80" />';
    $img2 =  '<img src="'.src($disc_img_path).'" width="80" />';
?>
<tbody>
    <tr>
        <td><input id="delid<?=$id?>" name="del[]" value="<?=$id?>" type="checkbox"><i class="layui-i">&nbsp;</i></td>
        <td><?=$id?></td>
        <td>
            <a href="a-brand-models.php?brand_id=<?=$id?>&callbackEvents=close" class="newLayerWindow layui-btn layui-btn-xs" style="height: 22px; line-height: 22px; padding: 0 5px; font-size: 12px;color:#fff">旗下系列(<?=ModelFactory('BrandModels')->countByBrand_id($id)?>)</a>|
            <a href="<?=$editUrl?>" class="thick ">编辑</a>|
            <a data-class="btn-warm" class="json <?=$isstate==1?'':'btn-warm' ?>" data-url="isstate&id=<?=$id?>"><?=config('webarr.isstate')[$isstate] ?></a>|
            <a data-class="btn-danger" class="json <?=$recommend==1?'btn-danger':'' ?>" data-url="is_recommend&id=<?=$id?>"><?=config('webarr.is_recommend')[$recommend] ?></a>|
            <a href="javascript:;" data-id="<?=$id?>" data-opt="del" class="thick del">删除</a>
        </td>

        <?php
            $opt->td(
                $img1,
                $img2,
                $brand_name
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
