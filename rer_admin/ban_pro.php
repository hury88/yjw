<?php

use  Core\response\Redirect as Redirect;

require './include/common.inc.php';

require WEB_ROOT.'./include/chkuser.inc.php';

$id= I('get.id', 0, 'intval');



if($row=M('news_cats')->where("id=$id")->find()){

    extract($row);

}

if(IS_POST)

{

    $fields=array();

    uppro('img1',$fields);

    uppro('img2',$fields);

    $fields['id'] = $id;

	if( M('news_cats')->update($fields) ) {

		Redirect::JsSuccess("更新数据成功,操作成功！",'ban.php');

	}else{

		Redirect::JsError("更新数据失败,操作失败！");

	}

	exit();

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8" />

    <?php define('IN_PRO',1);include('js/head'); ?>

<body>



	<div class="content clr">

    	<div class="weizhi">

            <p>位置：

                <a href="mains.php">首页</a>

                <span>></span>

                <a href="javascript:void()">栏目管理</a>

                <span>></span>

                <a href="javascript:void()">栏目修改</a>

            </p>

        </div>

    	<div class="right clr">



            <div class="zhengwen clr">

            	<div class="xuanhuan clr">

                	<a href="javascript:void()" class="zai" style="margin-left:30px;"><?=$row['catname']?></a>

                 </div>



                <div class="miaoshu clr">

                    <div id="tab1" class="tabson">

        				<div class="formtext">Hi，<b><?=$_SESSION['Admin_UserName']?></b>，欢迎您使用信息发布功能！</div>

                            <ul class="forminfo">

						<form name="form1" method="post" action="" onSubmit="return checkcats(this)" enctype="multipart/form-data">

							<li class="fade"><label>所属栏目<b>*</b></label><?=$row['catname']?></li>

                            <?php

                                $sizes = [0,'1920X613', '1920X602', '1920X802', '1920X734'];

                             ?>

                            <?php printImgHtml('图片','img1', '1920X600') ?>

                            <?php // printImgHtml('导航配图','img2','215*150') ?>

                            <input type="hidden" name="id" value="<?=$id?>" />

 							<li class="fade"><label>&nbsp;</label><input type="submit" class="btn" value="提  交"/></li>

						</form>

					   </ul>

      			  	</div>

                </div>



            </div>



        </div>





 	</div>



</body>

</html>

