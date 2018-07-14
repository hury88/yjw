<?php
class Daohang
{

	public static $fuzhuid = 6;
	public $data = [];

	public function __construct()
	{
		$this->data = M('news_cats')->field('catname,img1,catname2,id,pid')->where('pid = 0 and id <'.static::$fuzhuid)->order('disorder desc,id asc')->select();
	}

	public function sub_nav($s_pid)
	{
		return M('news_cats')->field('id,catname,img1,catname2,pid')->where('pid='.$s_pid.' and isstate=1')->order('disorder desc,id asc')->select();

	}

	public function erji_nav()
	{
		global $pid,$ty;
		$navs = $this->sub_nav($pid);
		$li = '';
		foreach ($navs as $id=> $value) {
			extract($value);
			$on = $ty == $id ? 'cur' : '';
			$url = "/web/index?pid=$pid&ty=$id" . ($pid==2?'&cate=1':'');
			$li	.= <<<LI
<li><a class="$on" href="$url"><span>$catname</span></a></li>
LI;
		}
		unset($navs, $id, $catname);
		return $li;
	}

	public static function pc_nav()
	{
		global $pid,$ty;

		$on = ' on';

		$level1 = M('news_cats')->field('pid,catname,catname2,id')->where('pid = 0 and id <='.static::$fuzhuid)->order('disorder desc,id asc')->select();

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


	public static function danceng($tpl='<li><a href="__URL__" title="@catname@">@catname@</a></li>')
	{
		global $pid,$ty;

		$on = ' cur';

		list($field, $flag) = \App\Helpers\V::parse($tpl);
		$data = $this->data;

		$list = '';
		foreach ($data as $key => $value) {
			extract($value);
			$cur = $pid == $id ? $on : '';
			$URL = u('web/index', ['pid' => $id]);
			$tpl = sprintf($tpl, $cur);
			eval(" \$list .= '$tpl';");
		}
		unset($field,$flag,$value,$data,$id,$key,$tpl);
		return $list;
	}

	public static function pc_foot()
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

}









