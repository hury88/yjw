<?php

use Core\Page as Page;

class Lister
{


    /**
     * @var object 对象实例
     */
    protected static $instance;


    private static $s4 = '';

    private static $s6 = '';

    private static $s7 = '';

    private static $row = '';//当前行的数据

    /*

        $showtype==1): showtype1($q,$ty) //新闻?>

        $showtype==2): showtype2($id)//单页?>

        $showtype==3): showtype3($ty) //图片列表?>

        $showtype==5): showtype5($ty) //单条?>

        $showtype==9): showtype9($q,$ty) //新闻2

        $showtype==8): showtype8($q,$ty) //文件下载

    */

    private $order = 'isgood desc,disorder desc,sendtime desc,id desc';
    private $psize = 12;
    private $table = 'news';
    private $map = array();
    public $field = '*';
    public $data = '';//数据
    public $paging = '';//模板
    public $display = '';//html


    private static $s1 = <<<T
<li class="item">
    <div class="clearfix">
        <div class="usImg"><img src="__IMG__" alt="@\$title@"></div>
        <div class="newsTxts">
            <div class="newsMore">
                <div class="newsNav">@\$title@</div>
                <a href="__URL__" class="moers">READ MORE</a>
            </div>
        </div>
    </div>
</li>
T;

    public function s1($psize = 5, $tpler = null)
    {//新闻列表

        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->noPaging($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            $class = $key % 2 == 0 ? '' : ' class="odd"';

            extract($value);
            $URL = U($pid, ['id' => $id]);
            $introduce = $introduce ? $introduce : cutstr($content, 55);

            eval(" \$list .= '$tpl';");

        }


        $this->display = $list;

        UNSET($data, $need, $tpl, $key, $row, $img, $url, $title, $list);

        return $this;

    }

    public function s2($field = '*', $ty = 0, $pid = 0)
    {

        if ($ty !== 0) {
            $this->map['ty'] = $ty;
        }
        if ($pid !== 0) {
            $this->map['pid'] = $pid;
        }

        $this->map['ty'] = -$this->map['ty'];

        $this->display = M($this->table)->field($field)->where($this->map)->find();

        return $this->display;
    }


    private static $s3 = <<<T
<li>
    <a href="javascript:;"><img src="__IMG__"> </a>
    <div class="txt">
        <a href="javascript:;">
            @\$title@<br>@\$ftitle@
        </a>
    </div>
</li>
T;

    public function s3($psize = 6, $tpler = null)
    {//图片列表

        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->j($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            extract($value);

            $introduce = cutstr($content, 150);

            eval(" \$list .= '$tpl';");

        }


        $this->display = $list;

        UNSET($data, $need, $tpl, $key, $row, $img, $url, $title, $list);

    }


    public function s4($psize = 4)
    {//友情链接

    }


    private static $s5 = <<<T
 <li class="item @\$class@">
    <div class="addrs">@\$title@</div>
    <div class="addrMain">
        __CONTENT__
    </div>
</li>
T;

    public function s5($psize = 5, $tpler = null)
    {//单条信息

        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->noPaging($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            if($key % 3 == 0) {
                $class = 'm1';
            } elseif($key % 3 == 1) {
                $class = 'm2';
            } else {
                $class = 'm3';
            }

            extract($value);

            eval(" \$list .= '$tpl';");

        }


        $this->display = $list;

        UNSET($data, $need, $tpl, $key, $row, $img, $url, $title, $list);

        return $this;

    }


    //新闻列表
    private static $dantiao = <<<T
<li class="contact-li wordel">
    <a title="@\$title@" href="__URL__">@\$title@</a>
    <span>__DATE__</span>
</li>
T;

//<img src="/style/img/icon8.png" class="new-infor"/>
    public function dantiao($psize = 5, $tpler = null)
    {//新闻列表

        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->j($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            extract($value);
            //if ($flag) {
            $URL = '/web/detail?id=' . $id;
//			}
            eval(" \$list .= '$tpl';");
        }
        $this->display = $list;
        UNSET($data, $tpler, $tpl, $key, $value, $img, $field, $field, $URL, $title, $list);
    }


    //下载中心
    private static $download = <<<T
<li class="down-lists-li">
    <a title="@\$title@" href="__URL__" download class="down-content wordel">· @\$title@</a>
    <a title="@\$title@" href="__URL__" download class="down-btn">下载</a>
</li>
T;

    public function download($psize = 5, $tpler = null)
    {//下载中心

        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->j($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            extract($value);

            $URL = $istop ? $linkurl : src($file);
            /*$htppPattern = '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/';
            if(preg_match($htppPattern,$row['linkurl']))*/
            eval(" \$list .= '$tpl';");
        }
        $this->display = $list;
        UNSET($data, $tpler, $tpl, $key, $value, $img, $field, $field, $URL, $title, $list);
    }


    private static $s9 = <<<T
 <li class="item">
    <div class="clearfix">
      <a href="__URL__" class="workLogo">
        <div class="workCons"><div class="table-cell"><img src="__IMG__" alt="@\$title@"></div></div>
      </a>
      <a href="__URL__" class="workImg"><img src="__IMG2__" alt="@\$title@"></a>
      <div class="workMore">
        <div class="workMoreText">
          <div class="span1">__TITLE__</div>
          <a href="__URL__" class="span2">VIEW WORK</a>
        </div>
      </div>
    </div>
  </li>
T;

    public function s9($psize = 99, $tpler = null)
    {//产品列表
        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->noPaging($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            $class = $key % 2 == 0 ? '' : ' class="odd"';

            extract($value);

            $URL = U($pid, ['id' => $id]);

            $introduce = $introduce ? $introduce : cutstr($content, 55);
            $title = $ftitle ? htmlspecialchars_decode($ftitle) : cutstr($content, 10);

            eval(" \$list .= '$tpl';");

        }


        $this->display = $list;

        UNSET($data, $need, $tpl, $key, $row, $img, $url, $title, $list);

    }

    private static $s11 = <<<T
<li class="item">
    <div class="clearfix">
        <div class="usImg"><img src="__IMG__" alt="@\$title@"></div>
        <div class="usTxt">
            <div class="ustMain">
                <div class="names"><span class="span1">@\$title@</span>@\$ftitle@</div>
                <div class="peos">@\$source@</div>
                <a href="__URL__" class="mores">READ PROPILE</a>
            </div>
        </div>
    </div>
</li>   
T;

    public function s11($psize = 99, $tpler = null)
    {//产品列表
        is_null($tpler) && $tpler = __FUNCTION__;
        list($data, $tpl) = $this->noPaging($tpler, $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';
        foreach ($data as $key => $value) {

            $class = $key % 2 == 0 ? '' : ' class="odd"';

            extract($value);

            $URL = U($pid, ['id' => $id]);

            $introduce = $introduce ? $introduce : cutstr($content, 55);

            eval(" \$list .= '$tpl';");

        }


        $this->display = $list;

        UNSET($data, $need, $tpl, $key, $row, $img, $url, $title, $list);

    }


    public function noPaging($m)
    {

        $table = $this->table;
        $field = $this->field;
        $where = $this->map;
        $order = $this->order;

        if (!empty($table)) {
            $this->table = $table;
        }
        $data = M($table)->field($field)->where($where)->order($order)->select();

        $pageConfig = array(

            'where' => $this->map,//条件
            'order' => $this->order,//排序
            'psize' => $this->psize,//条数
            'table' => $this->table,//表
            'style' => 'data-url',

        );

        $tpl = strlen($m) > 5 ? $m : self::$$m;

        \V::parse($tpl);
        return array($data, $tpl);
    }


    public function j($m, $psize = 0, $table = '')
    {

        if (!empty($psize)) {
            $this->psize = $psize;
        }
        if (!empty($table)) {
            $this->table = $table;
        }

        $pageConfig = array(

            'where' => $this->map,//条件
            'order' => $this->order,//排序
            'psize' => $this->psize,//条数
            'table' => $this->table,//表
            'field' => $this->field,//表
            'style' => 'href',
        );

        list($data, $pagestr, $totalRows) = Page::paging($pageConfig, 'show_front');
        //if( empty($data) ){exit('<p style="text-align:center;width:100%;padding-top:20px;">内容更新中</p>'); }
        $tpl = $m ? self::$$m : '';
        \V::parse($tpl);
        $this->paging = $pagestr;
        $this->totalRows = $totalRows;
        return array($data, $tpl);
    }

    public function search($psize = 5, $tpler = null)
    {//搜索
        global $q;

        $q = urldecode($q);

        $map = array();
        // if ($pid) $map['pid']=$pid;
        // if ($ty)  $map['ty']=$ty;
        $tys = M('news_cats')->where('pid<>0 and (showtype=5 or showtype=1)')->getField('id', true);
        $tys = implode(',', $tys);
        $map['_string'] = 'ty in(' . $tys . ') and title like "%' . $q . '%"';
        $this->map = $map;
        list($data, $tpl) = $this->j('dantiao', $psize);
        if (empty($data)) {
            $this->display = config('other.nocontent');
            return;
        }

        $list = '';

        foreach ($data as $key => $row) {


            extract($row);
            $URL = '/web/detail?id=' . $id;
            eval(" \$list .= '$tpl';");
        }

        $this->display = $list;

        UNSET($data, $tpler, $tpl, $key, $row, $img, $field, $field, $URL, $title, $list);

    }

    public function where($where = array())
    {
        is_array($where) or $where = array();
        $this->map = array_merge($this->map, $where);
    }

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return \think\Request
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }


    public function __construct($pid = null, $ty = null, $tty = null)
    {
        global $q;
        if (is_null($pid)) global $pid;
        if (is_null($ty)) global $ty;
        if (is_null($tty)) global $tty;

        $map = array('pid' => $pid, 'ty' => $ty);
        if ($q) {
            $map['title'] = array('like', '%' . $q . '%');/*搜索*/
        }
        if ($tty) {
            $map['tty'] = $tty;
        }

        $this->map = $map;
    }


    public function display()
    {

        return
            '<ul class="alliance-lists">' . $this->display . '</ul>' .
            '<div class="inside-pager">' . $this->paging . '</div>';

    }

    public function run($tpl = null, $psize = 15)
    {
        global $showtype;

        $showtype == 2 ? $this->s2(is_null($tpl) ? '*' : $tpl) : $this->{'s' . $showtype}($psize, $tpl);

        return $this;
    }
}
