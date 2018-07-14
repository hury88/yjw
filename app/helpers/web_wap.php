<?php
if (! defined('WEB')) return;

function about_nav($pid)
{
	$on = ' on';

	$level1 = M('news_cats')->field('catname,id')->where('pid = '.$pid)->order('disorder desc,id asc')->select();

	$nav = '';

	foreach ($level1 as $row1) {
		$catname1 = $row1['catname'];$ty = $row1['id'];
		$u1 = u('web/index', ['pid' => $pid, 'ty' => $ty]);
		$cur = $pid == $ty ? $on : '';

		#查询二级
		$nav2 = '';

		$level2 = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$ty.' and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($level2 as $row2) {
			$catname2 = $row2['catname'];$tty = $row2['id'];
			$u2 = u('web/index', ['pid' => $pid, 'ty' => $ty, 'tty' => $tty]);
			$nav2 .= '<div class="ml30"><a title="'.$catname2.'" href="'.$u2.'">'.$catname2.'</a></div>';
		}

$nav .= <<<NAV
<li><a href="$u1" title="$catname1" class="fwb">$catname1</a>$nav2</li>
NAV;
	}

	// $index = '<li class="nav_li'.(IS_INDEX?$on:'').'"> <a href="/" class="nav_li_a">首页</a></li>';

	unset($pid,$ty,$OnClass,$on,$nav2,$row1,$catname1,$u1,$id1,$row2,$catname2,$u2,$id2,$cur);
	return $nav;
}


function pc_nav1()
{
	global $pid,$ty;

	$OnClass = ' class="nav-selected"';

	$data = M('news_cats')->where('pid = 0 and id <=4')->field('catname,id,pid')->order('disorder desc,id asc')->select();
	$on = IS_INDEX ? $OnClass : '';
	$pid = isset($pid) ? $pid : 0;
	$class=$temp='';//当前停留样式
	$tpl_ul = '<li%s> <a href="%s">%s</a> %s </li>';
    $tmp1='';
	foreach ($data as $row) {
		$tmp2='';
		$thispid = $row['id'];
		$class = $thispid == $pid ? $OnClass : '';
		$yiji_url = U('web/index', ['pid' => $thispid]);
		$yiji_catname = $row['catname'];
		// $yiji_img = src($row['img2']);
		$tmp1 .= '<li'.$class.'><a href="'.$yiji_url.'">'.$yiji_catname.'</a></li>';
	}
	echo '<li'.$on.'><a href="/">首页</a></li>' . $tmp1;
	unset($tmp1,$tmp2,$cur,$navs,$row,$key,$class,$url,$tpl1,$tpl2,$yiji_url,$yiji_catname,$erji_url,$erji_catname,$erjiRow,$template);
}

function pc_nav2()
{
	global $pid,$ty;

	$on = ' on';

	$level1 = M('news_cats')->field('catname,id')->where('pid = 0 and id <=7')->order('disorder desc,id asc')->select();

	$nav = '';

	foreach ($level1 as $row1) {
		$catname1 = $row1['catname'];$id1 = $row1['id'];
		$u1 = u('web/index', ['pid' => $id1]);
		$cur = $pid == $id1 ? $on : '';

		#查询二级
		$nav2 = '';

		$level2 = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$id1.' and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($level2 as $row2) {
			$catname2 = $row2['catname'];$id2 = $row2['id'];
			$u2 = u('web/index', ['pid' => $id1, 'ty' => $id2]);
			$nav2 .= '<li><a title="'.$catname2.'" href="'.$u2.'">'.$catname2.'</a></li>';
		}

$nav .= <<<NAV
<li class="nav_li$cur">
    <a href="$u1" title="$catname1" class="nav_li_a">$catname1</a>
    <div class="ej clr">
        <ul>
            $nav2
        </ul>
    </div>
</li>
NAV;
	}

	$index = '<li class="nav_li'.(IS_INDEX?$on:'').'"> <a href="/" class="nav_li_a">首页</a></li>';

	unset($pid,$ty,$OnClass,$on,$nav2,$row1,$catname1,$u1,$id1,$row2,$catname2,$u2,$id2,$cur);
	return $index . $nav;
}
function pc_foot1()
{
	global $pid,$ty;

	$on = '';

	$level1 = M('news_cats')->field('catname,id')->where('pid = 0 and id <=6')->order('disorder desc,id asc')->select();

	$nav = '';

	foreach ($level1 as $row1) {
		$catname1 = $row1['catname'];$id1 = $row1['id'];
		$u1 = u('web/index', ['pid' => $id1]);
		$cur = $pid == $id1 ? $on : '';
$nav .= <<<NAV
<li><a href="$u1" title="$catname1">$catname1</a></li>
NAV;
	}

	unset($pid,$ty,$OnClass,$on,$nav2,$row1,$catname1,$u1,$id1,$row2,$catname2,$u2,$id2,$cur);
	return $nav;
}
function pc_foot2()
{
	global $pid,$ty;

	$on = ' on';

	$level1 = M('news_cats')->field('catname,id')->where('pid = 0 and id <=7')->order('disorder desc,id asc')->select();

	$nav = '';

	foreach ($level1 as $row1) {
		$catname1 = $row1['catname'];$id1 = $row1['id'];
		$u1 = u('web/index', ['pid' => $id1]);
		$cur = $pid == $id1 ? $on : '';

		#查询二级
		$nav2 = '';

		$level2 = M('news_cats')->field('id,catname')->where('pid<>0 and pid='.$id1.' and isstate=1')->order('disorder desc,id asc')->select();
		foreach ($level2 as $row2) {
			$catname2 = $row2['catname'];$id2 = $row2['id'];
			$u2 = u('web/index', ['pid' => $id1, 'ty' => $id2]);
			$nav2 .= '<li><a title="'.$catname2.'" href="'.$u2.'">'.$catname2.'</a></li>';
		}

$nav .= <<<NAV
<div class="foot_nav_list fl">
    <ul>
        <li><a href="$u1" title="$catname1">$catname1</a></li>
        $nav2
    </ul>
</div>
NAV;
	}

	unset($pid,$ty,$OnClass,$on,$nav2,$row1,$catname1,$u1,$id1,$row2,$catname2,$u2,$id2,$cur);
	return $nav;
}
