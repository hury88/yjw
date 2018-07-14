<?php

if ( defined('WEB') ) {



function show_tab($pid,$ty, $ids)

{

	$m = M('news')->where(m_gWhere($pid,$ty))->order('disorder desc, isgood desc, id asc')->getField('id,title');

	$ids = explode(',', $ids);

	$tabs =  [];

	foreach ($ids as $id) {

		array_push($tabs, $m[$id]);

	}

	return implode('<em>/</em>', $tabs);

	// return $tabs;

}



function returnJson($status,$msg,$dom=false){

    $arr = [

    	'status' => $status,

    	'msg'    => $msg,

    ];

    $dom && $arr['dom'] = $dom;

    unset($status,$msg,$dom);

    die( json_encode($arr) );

}



function dieJson($error,$message,$redirect=false){

    $arr = [

    	'error' => $error,

    	'message'    => $message,

    ];

    $redirect && $arr['redirect'] = $redirect;

    unset($error,$message,$redirect);

    die( json_encode($arr) );

}

// 用法 <li><a style="background-image: url(__IMG__);" href="@$linkurl@"></a></li>

function v_data($pid,$ty,$field='*',$limit=0)

{

	$m = M('news')->field($field)->where(m_gWhere($pid,$ty))->order(config('other.order'));

	if ($limit) {

	    $m = $m->limit($limit);

	}

	$data = $m->select();

	return $data;

}

function vv($pid,$ty,$tpl,$limit=0)

{

	global $key;

	list($field, $flag) = V::parse($tpl);

	$m = M('news')->field($field)->where(m_gWhere($pid,$ty))->order(config('other.order'));

	if ($limit) {

	    $m = $m->limit($limit);

	}

	$data = $m->select();



	$list = '';

	foreach ($data as $key => $value) {

		extract($value);

		if ($flag) {

			$URL = U($pid.'/detail', ['id'=>$id]);

		}

		eval(" \$list .= '$tpl';");

	}

	return $list;

}



function vv_data($data,$tpl)

{

	list($field, $flag) = V::parse($tpl);



	$list = '';

	foreach ($data as $key => $value) {

		extract($value);

		if ($flag) {

			$URL = "web/index?pid=$pid&ty=$ty";

		}

		eval(" \$list .= '$tpl';");

	}

	return $list;

}



function vvpro($set,$tpl,$limit=0)

{

	$pid=$ty=$tty = null;

	$where = [];

	list($field) = V::parse($tpl);



	list($pid, $ty, $tty) = $set;

	if ($pid) $where['pid'] = $pid;

	if ($ty) $where['ty'] = $ty;

	if ($tty) $where['tty'] = $tty;



	$m = M('news')->field($field)->where((array) $where)->order(config('other.order'));

	if ($limit) {

	    $m = $m->limit($limit);

	}

	$data = $m->select();



	$list = '';

	foreach ($data as $key => $value) {

		extract($value);

		eval(" \$list .= '$tpl';");

	}

	return $list;

}



    function uppro11($name){
        $path = ROOT_PATH .config("pic.upload");

        if(!isset($_FILES[$name]))return '';
        $img_name = $_FILES[$name]['name'];
        $imgtype = explode(".", basename($img_name));
        $imgtype = end($imgtype);
        if($img_name){
            $imgnewname=date("YmdHis").mt_rand(10,99).".".$imgtype;
            uploadimg111($name,$path,$imgnewname);
            return  $imgnewname;
        }
        return false;

    }

    function uploadimg111($obj,$path,$name){
        global $system_pictype,$system_picsize;
        $picsAllowExt  = 'png|jpg|jpeg|gif';                               //允许上传图片类型
        $picmax_thumbs_size=2048;                            //允许上传图片大小
        $picaExt = explode("|",$picsAllowExt);                          //图片文件
        $uppic=$_FILES[$obj]['name'];                                   //文件名称
        $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
        $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
        $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
        $imageinfo = getimagesize($thumbs_file);

        $upfile=$path.$name;
        if(in_array($thumbs_type,$picaExt)&&$thumbs_size>intval($picmax_thumbs_size)*1024){
            JsError("图片上传大小超过上限:".ceil($picmax_thumbs_size/1024)."M！");
            exit();
        }

        if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
            JsError("非法图像文件！");
            exit();
        }

        if(!in_array($thumbs_type,$picaExt)){
            JsError("上传图片格式不对，请上传".$System_Pictype."格式的图片！");
            exit();
        }
        if (!is_writable($path)){
            //修改文件夹权限
            $oldumask = umask(0);
            mkdir($path,0777);
            umask($oldumask);
            if(C('DEBUG'))$rePath=$path;
            JsError('请确保文件夹的存在或文件夹有写入权限!'.$rePath);
            exit();
        }
        if(!copy($thumbs_file,$upfile)){
            JsError('上传失败!');
            exit();
        };
    }
#常用小函数 统一前缀 m



	function m_url($pid,$ty=0, $route = 'web/index')

	{

		$args = ['pid' => $pid];

		if (!empty($ty)) $args['ty'] = $ty;

		return U($route, $args);

	}//传入pid=>list.php?pid=n





	function htmldecode($html) {return htmlspecialchars_decode($html);}

	function pc_bread($sp = '>')

	{//面包屑导航

		global $q,$tty,$ty,$pid,$id_title,$id,$pid_catname,$ty_catname,$ty_catname2;

		  //面包屑导航

		  //$bread = $tty ? : $ty ? : $pid ;

		if ($q) {

			// ECHO '搜索"'.$q.'"的结果';

			// echo '搜索';

			return;

		}

		$array = [];

		$breadTemp = '';





		$array[] = ['首页', '/'];

		// $breadTemp = '<a href="/" style="font-style:italic">'.config('translator.home').'</a>' .$sp;

		if($pid){

			$array[] = [$pid_catname, m_url($pid)];

		}

		if($ty && $pid_catname != $ty_catname){

			if (empty($ty)) {$separtor='';}

			$array[] = [$ty_catname, m_url($pid, $ty)];

		}



		if ($id){

			global $id_title;

			$array[] = [$id_title, 'javascript:;'];

			// $breadTempId='<a href="javascript:;" style="color: #4a81c1;">'.$id_title.'</a>';

		}

		$count = count($array)-1;

		foreach ($array as $key => $value) {

			if ($count==$key) {

				$breadTemp .= '<span>'.$value[0].'</span>';

			} else {

				$breadTemp .= sprintf('<a href="%s">%s</a>'.$sp, $value[1], $value[0]);

			}

		}

		unset($url,$catname,$bread);

		return $breadTemp;

	}



} //END WEB