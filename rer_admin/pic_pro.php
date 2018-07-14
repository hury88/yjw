<?php

namespace Admin;

require './include/common.inc.php';

define('TABLE_NEWS',1);

require WEB_ROOT.'./include/chkuser.inc.php';

$table    = 'pic';

$showname = 'pic';

$ti  = I('get.ti',0,'intval');

$ci  = I('get.ci',0,'intval');

if (!empty($id) ) { //显示页面 点击修改  只传了id

	$row = M($table)->find($id);

	extract($row);

}

$opt = new Output;//输出流  输出表单元素

?>

<!DOCTYPE html>

<html lang="en" ng-app="app">

<head>

	<meta charset="UTF-8" />

	<title>相册管理</title>

	<?php define('IN_PRO',1);include('js/head'); ?>

</head>



<body>





	<div class="content clr">

		<div class="right clr">

			<div class="zhengwen clr">

				<div class="xuanhuan clr">

					<a href="javascript:void()" class="zai" style="margin-left:30px;">图片管理</a>

				</div>



				<div class="miaoshu clr">

					<div id="tab1" class="tabson">

						<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>

						<!-- 表单提交 --><form id="dataForm" class="layui-form" method="post" enctype="multipart/form-data">

						<?php Style::output();Style::submitButton();

							(!isset($title) || ! $title ) && $title = M('news')->where("id=$ti")->getField('title');

							$opt

							->ifs($ti==20)

								->img('列表图配图','img1', '545*664')

							->endifs()

							// ->input('标题','title')

							->ifs($ci==1)->img('轮播配图','img1', '1020X980px')->editor('轮播文字', 'content', '90%', '100px')->endifs()

							->ifs($ci==2)->img('列表图配图','img1', '1006X628')->endifs()

							->ifs($ci==3)->img('列表图配图','img1', '1200X735')->endifs()

							->ifs($ci==4)->img('列表图配图','img1', '140X371')->endifs()

							// ->ifs($ti==24)->word('细节图文字')->editor()->endifs()

							->hide('ti')

							->hide('ci')





							;include('js/foot');

						?>

