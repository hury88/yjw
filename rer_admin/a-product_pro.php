<?php
namespace Admin;
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'product';
$showname = 'a-product';
//条件
###########################额外参数配置开始
$brand_id = I('get.brand_id','','intval');if(!empty($brand_id))$map['brand_id'] = $brand_id;
###########################额外参数配置结束


if (!empty($id) ) { //显示页面 点击修改  只传了id

	$row = M($table)->find($id);

	extract($row);

}

$opt = new Output;//输出流  输出表单元素
if (isset($_GET['action']) && $_GET['action']=='delImg') {
	$id = I('get.id',0,'intval');
	$img = I('get.img');
	$path = ROOT_PATH.I('get.path');
	M($table)->where("id=$id")->setField($img,'');
	@unlink($path);
	JsError('删除成功!');
}
?>
<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="UTF-8" />
	<?php define('IN_PRO',1);include('js/head'); ?>
</head>

<body>


	<div class="content clr">
		<div class="right clr">
			<div class="zhengwen clr">
				<div class="miaoshu clr">
					<div id="tab1" class="tabson">
						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>
						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">
						<?php Style::output();Style::submitButton() ?>
<?php

/*$opt->verify('')->input('页面标题','seotitle')->input('页面关键字','keywords')->textarea('页面描述','description');*/

    //$d2 = M('news')->where('pid=1 and ty=9')->order('disorder desc, isgood desc, id asc')->getField('id,title');Output::select($d2,'城市','city_id');

    $seriesModel = ModelFactory('brandModels');
//    $opt
//        ->groupSelect($d, $groupCate,'品牌','brand_id', 'initials');
    $opt
        ->img('图片','img_path')
        ->input('名称','prod_name')
        ->cache()
            ->input('价格','price')
        ->flur()
        ->choose('型号','version')->radiobox( $seriesModel->explodeResult('version', $brand_id) )
        ->choose('色号','prod_color')->radiobox( $seriesModel->explodeResult('prod_color', $brand_id) )
        ->choose('镜框尺寸','mirr_width')->radiobox( $seriesModel->explodeResult('mirr_width', $brand_id) )
        ->choose('鼻梁尺寸','nose_width')->radiobox( $seriesModel->explodeResult('nose_width', $brand_id) )
    ;

include('js/foot');
