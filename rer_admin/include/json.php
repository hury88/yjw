<?php
require 'common.inc.php';
require 'chkuser.inc.php';

//所有的提交集中处理
$action=I('get.action','','trim,htmlspecialchars');
//后台选择企业
if($action=='quyu'){
    $city_id=I('get.city_id','0','intval');
    $d4=M('news')->where('istop='.$city_id.' and isstate=1 and istop>0')->order('disorder desc, isgood desc, id asc')->getField('id,title');
    $d5=M('news')->where('istop2='.$city_id.' and isstate=1 and istop2>0')->order('disorder desc, isgood desc, id asc')->getField('id,title');
    $str='';
    $str .= '<optgroup label="地区">';
    foreach  ($d4 as $k => $v){
        $str .="<option value=\"{$k}\">{$v}</option>";
    }
    $str .= '</optgroup>';

    $str .= '<optgroup label="商圈">';
    foreach  ($d5 as $k => $v){
        $str .="<option value=\"{$k}\">{$v}</option>";
    }
    $str .= '</optgroup>';

    echo $str;
    exit();
}elseif($action=='shangquan'){
    $city_id=I('get.city_id','0','intval');
    $d5=M('news')->where('istop2='.$city_id.' and isstate=1 and istop2>0')->order('disorder desc, isgood desc, id asc')->getField('id,title');
    $str=array();

    foreach  ($d5 as $k => $v){
        $str.="<option value=\"{$k}\">{$v}</option>";
    }
    echo $str;
    exit();
}
 ?>