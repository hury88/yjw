<?php
namespace Admin;
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';

$table = 'product';
$showname = 'a-product';


if (!empty($id) ) { //显示页面 点击修改  只传了id

    $row = M($table)->find($id);

    extract($row);

}
//条件
###########################额外参数配置开始
$prod_brand = I('get.prod_brand','','intval');
$prod_series = I('get.prod_series','','intval');
###########################额外参数配置结束

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
//        ->groupSelect($d, $groupCate,'品牌','prod_series', 'initials');
    $opt
        ->img('图片','img_path', '400X205')
        ->verify('required')->input('名称','prod_name')
        ->cache()
            ->verify('required')->input('价格','market_price')
        ->flur()
        ->choose('型号','version')->radioSet( $seriesModel->explodeResult('version', $prod_brand), 'k=v' )->flur()
        ->choose('色号','prod_color')->radioSet( $seriesModel->explodeResult('prod_color', $prod_brand), 'k=v' )->flur()
        ->choose('镜框尺寸','mirr_width')->radioSet( $seriesModel->explodeResult('mirr_width', $prod_brand), 'k=v' )->flur()
        ->choose('鼻梁尺寸','nose_width')->radioSet( $seriesModel->explodeResult('nose_width', $prod_brand), 'k=v' )->flur()
        ->choose('框架','shape')->radioSet( $seriesModel->explodeResult2('shape', $prod_brand) )->flur()
        ->choose('款式','style')->radioSet( $seriesModel->explodeResult2('style', $prod_brand) )->flur()
        ->hide('prod_brand')
        ->hide('prod_series')
    ;

include('js/foot');
