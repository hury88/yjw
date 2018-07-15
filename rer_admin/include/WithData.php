<?php

namespace Admin;

/**
 *public function submit()     统一提交
 *#以下方法名对应表名称
 *public function news()      []
 *public function config()    []
 *public function content()   [] 映射->news表
 *public function news_cats() [] news_cats表
 *public function class_cat() [] news_cats表(超级管理员用的)
 *public function pic()		  []
 *public function brand()	  []
 *public function brand_models()	  []
 *public function product()	  []
 *public function user()	  []
 */

class WithData

{



	protected $fields = [];
	protected $table = '';
	protected $isUpdate = 0;
	protected $isInsert = 0;
	protected $logInsert = '';// 插入数据时的日志
	protected $logUpdate = '';// 更新时的日志
	// 表映射

	private static $map = [
		'content' => 'news',
	    'class_cat' => 'news_cats',
	];



	public function __construct($table, $id)
	{

		if ( $id ) {
			$this->isUpdate = $id;
		} else {
			$this->isInsert = 1;
		}

		$this->table  = $table;
		$this->fields = $this->$table();
		isset(self::$map[$table]) && $this->table = self::$map[$table];
	}





	// 提交数据

	public function submit()
	{
		$id        = $this->isUpdate;
		$table     = $this->table;
		$logUpdate = $this->logUpdate;
		$logInsert = $this->logInsert;
		if ( $id ) {// 执行更新

			$this->fields['id'] = $id;
			if($update = M($table)->update($this->fields) ) {
				$logUpdate && AddLog($logUpdate, $_SESSION['Admin_UserName']);
				return [1, '更新数据成功'];
			}else{
				return [0, '更新数据失败!'];
			}
		}else{// 执行插入

			$this->fields['isstate'] = 1;
			if($insert = M($table)->insert($this->fields) ) {

				$logInsert && AddLog($logInsert, $_SESSION['Admin_UserName']);
				return [6, '添加数据成功'];
			}else{
				return [5, '添加数据失败!'];

			}
		}
	}





	public function news()
	{
		$istop = I('post.istop',0,'intval');
		$relative = isset($_POST['relative']) && is_array($_POST['relative'])?implode(',',$_POST['relative']):'';

		$json = isset($_POST['json']) ? json_encode($_POST['json'], JSON_UNESCAPED_UNICODE) : '';

		$fields = array(
			'pid'				=>		I('pid', 0, 'intval'),
			'ty'				=>		I('ty' , 0, 'intval'),
			'tty'				=>		I('tty', 0, 'intval'),
			'title'				=>		I('post.title','','trim,htmlspecialchars'),
			'ftitle'			=>		I('post.ftitle','','trim,htmlspecialchars'),
			'content'			=>		I('post.content',''),
			'content2'       	=>		I('post.content2',''),
			'content3'       	=>		I('post.content3',''),
			'content4'       	=>		I('post.content4',''),
			'content5'       	=>		I('post.content5',''),
			'name'				=>		I('post.name','','trim'),
			'source'			=>		I('post.source','','trim,htmlspecialchars'),
			'relative'			=>		$relative,
			'introduce'			=>		I('post.introduce','','trim,htmlspecialchars'),
			'price'				=>		I('post.price','','trim,htmlspecialchars'),
			'linkurl'			=>		I('post.linkurl','','trim,htmlspecialchars'),
			'link1'				=>		I('post.link1','','trim,htmlspecialchars'),
			'link2'				=>		I('post.link2','','trim,htmlspecialchars'),
			#资讯
			'json'      	=>		$json,
			//SEO
			'seotitle'		    =>		I('post.seotitle','','trim'),
			'keywords'		    =>		I('post.keywords','','trim'),
			'description'		=>		I('post.description','','trim'),

			'disorder'      	=>		I('post.disorder',0,'intval'),
			'hits'      		=>		I('post.hits',1,'intval'),
			'istop'      	 	=>		I('post.istop',0,'intval'),
			'istop2'      	 	=>		I('post.istop2',0,'intval'),
			'sendtime'      	=>		I('post.sendtime',0,'strtotime'),



		);

		if (isset($_POST['istop']) && empty($fields['istop'])) {
			ajaxReturn(-1,'请选择分类');

		}

		/*if ($fields['ty'] == 10 && empty($fields['istop2'])) {

			ajaxReturn(-1,'请选择案例分类');

		}
*/

		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');
		uppro('img4',$fields,'ajax');
		uppro('img5',$fields,'ajax');
		uppro('img6',$fields,'ajax');
		uppro('file',$fields,'file');
		// uppro('img5',$fields,'water',$water_path);

		$this->logInsert = "添加信息: ".$fields['title'];
		$this->logUpdate = '更新信息: '.$fields['title'];

		return $fields;

	}





	/**
	 * [config config.php]
	 * @return [type] [提交过来的]
	 */

	public function config()
	{
		$fields=[];

		$fields['sitename']		=	I('post.sitename', '', 'trim');
		if($_SESSION['is_hidden']==true){
			$fields['isstate']	=	I('post.isstate', 0, 'intval');
			$fields['showinfo']	=	I('post.showinfo', '', 'trim,htmlspecialchars');
		}

		$fields['filetype']		=	I('post.filetype', '', 'trim,htmlspecialchars');
		$fields['filesize']		=	I('post.filesize', '', 'trim,htmlspecialchars');
		$fields['pictype']		=	I('post.pictype', '', 'trim,htmlspecialchars');
		$fields['picsize']		=	I('post.picsize', '', 'trim,htmlspecialchars');
		$fields['hotsearch']	=	I('post.hotsearch', '', 'trim,htmlspecialchars');
		$fields['seotitle']		=	I('post.seotitle', '', 'trim,htmlspecialchars');
		$fields['keywords']		=	I('post.keywords', '', 'trim,htmlspecialchars');
		$fields['description']  =	I('post.description', '', 'trim,htmlspecialchars');
		$fields['isrewrite']=0;//伪静态
		$fields['indexabout']	=	I('post.indexabout', '', 'trim,htmlspecialchars');
		$fields['indexcontact'] =	I('post.indexcontact', '', 'trim,htmlspecialchars');
		$fields['link']		=	I('post.link', '', 'trim,htmlspecialchars');#普通团车
		$fields['link1']		=	I('post.link1', '', 'trim,htmlspecialchars');#普通团车
		$fields['link2']		=	I('post.link2', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link3']		=	I('post.link3', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link4']		=	I('post.link4', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link5']		=	I('post.link5', '', 'trim,htmlspecialchars');#团子秒车
		$fields['link6']		=	I('post.link6', '', 'trim,htmlspecialchars');#团子秒车
		#微信
		$fields['oauth']		=	I('post.oauth', '', 'trim,htmlspecialchars');#网页验证
		$fields['appid']		=	I('post.appid', '', 'trim,htmlspecialchars');#公众号id
		$fields['appsecret']	=	I('post.appsecret', '', 'trim,htmlspecialchars');#公众token

		$fields['email']		=	I('post.email', '', 'trim,htmlspecialchars');#邮箱
		$fields['tel']			=	I('post.tel', '', 'trim,htmlspecialchars');
		$fields['fax']			=	I('post.fax', '', 'trim');
		$fields['phone']		=	I('post.phone', '', 'trim,htmlspecialchars');
		$fields['address']		=	I('post.address', '', 'trim,htmlspecialchars');#地址
		$fields['siteurl']		=	I('post.siteurl', '', 'trim,htmlspecialchars');#pc端地址
		$fields['siteurl_wap']	=	I('post.siteurl_wap', '', 'trim,htmlspecialchars');#手机端地址
		$fields['webqq']		=	I('post.webqq', '', 'trim,htmlspecialchars');
		$fields['icpcode']		=	I('post.icpcode', '', 'trim,htmlspecialchars');//备案号
		//textarea
		$fields['header']     	=   I('post.header', '', '');//全局代码一般
		$fields['copyright']  	=   I('post.copyright', '', '');//版权信息 不做处理

		uppro('logo1', $fields, 'ajax');
		uppro('logo2', $fields, 'ajax');
		uppro('img1', $fields, 'ajax');
		uppro('img2', $fields, 'ajax');
		uppro('file',$fields,'file');
		// $this->logInsert = '编辑系统信息';
		$this->logUpdate = '编辑系统信息';
		return $fields;

	}



	// content.php

	public function content()

	{

		$ty = I('post.ty',  0, 'intval');

		$fields = array(

			'pid'			=>	I('post.pid', 0, 'intval'),

			'ty'			=>	-$ty,

			'tty'			=>	I('post.tty', 0, 'intval'),

			'title'			=>	v_news_cats($ty,'catname'),

			'ftitle'		=>	I('post.ftitle',''),

			'name'   		=>	I('post.name',''),

			'introduce'     =>  I('post.introduce',''),

			'content'		=>	I('post.content',''),

			'content2'		=>	I('post.content2',''),

			'content3'		=>	I('post.content3',''),

			'content4'		=>	I('post.content4',''),

			'content5'		=>	I('post.content5',''),

			'source'		=>	I('post.source',''),

			'linkurl'		=>	I('post.linkurl',''),

			'sendtime'		=>	I('post.sendtime',0,'strtotime'),

		);

		uppro('img1',$fields,'ajax');

		uppro('img2',$fields,'ajax');

		uppro('img3',$fields,'ajax');

		uppro('img4',$fields,'ajax');

		uppro('img5',$fields,'ajax');

		uppro('file',$fields,'file');



		$this->logInsert = '添加单页->'.$fields['title'];

		$this->logUpdate = '编辑单页->'.$fields['title'];



		return $fields;

	}



	public function news_cats()
	{
		$fields=array(
			'pid'		  =>	    I('post.pid', 0, 'intval'),
			'showtype'     => 		I('post.showtype', 0, 'intval'),
			'catname'     => 		I('post.catname','','trim'),
			'catname2'    => 		I('post.catname2','','trim'),
			'seotitle'    =>	 	I('post.seotitle','','trim'),
			'keywords'    =>	 	I('post.keywords','','trim'),
			'description' =>	 	I('post.description','','trim'),
			);

		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');

		$this->logInsert = '添加栏目分类'.$fields['catname'];
		$this->logUpdate = '编辑栏目分类'.$fields['catname'];

		return $fields;
	}


	public function class_cat()
	{
		$fields=array(
			'pid' 		  => 		I('post.pid',0,'intval'),
			'catname'     => 		I('post.catname','','trim'),
			'catname2'    => 		I('post.catname2','','trim'),
			'tpl'         =>	    I('post.tpl','','trim'),
			'imgsize'     =>	 	I('post.imgsize','','trim'),
			'seotitle'    =>	 	I('post.seotitle','','trim'),
			'keywords'    =>	 	I('post.keywords','','trim'),
			'description' =>	 	I('post.description','','trim'),
			'linkurl'     =>	 	I('post.linkurl','','trim'),
			'contentTemplate'=>	I('post.contentTemplate',''),
			'weblinkurl'  =>	 	I('post.weblinkurl','','trim'),
			'showtype'    =>	 	I('post.showtype',1,'intval'),
			'disorder'    =>	 	I('post.disorder',0,'intval'),
			'iscats'      =>	 	I('post.iscats',0,'intval'),
			);

		uppro('img1',$fields,'ajax');
		uppro('img2',$fields,'ajax');
		uppro('img3',$fields,'ajax');

		$this->logInsert = '添加栏目分类'.$fields['catname'];
		$this->logUpdate = '编辑栏目分类'.$fields['catname'];

		if ($this->isInsert) {
			$fields['isstate']=1;
			$fields['ishidden']=1;
		}

		return $fields;
	}



	public function pic()

	{

		$fields = array(

			'ti'			=>	I('post.ti',0,'intval'),

			'ci'			=>	I('post.ci',0,'intval'),

			'title'			=>	I('post.title',''),

			'content'		=>	I('post.content',''),

			'linkurl'		=>	I('post.linkurl','','trim,htmlspecialchars'),

			'disorder'    =>	 	I('post.disorder',0,'intval'),

			'sendtime'		=>	I('post.sendtime',0,'strtotime'),

		);

		uppro('img1',$fields,'ajax');

		uppro('img2',$fields,'ajax');

		$this->logInsert = '添加图片->'.$fields['title'];

		$this->logUpdate = '编辑图片->'.$fields['title'];

		return $fields;



	}

    //品牌
    public function brand()
    {
        $type_value = I('post.type_value',1,'intval');

        if ($type_value == -1) {

            ajaxReturn(-1,'品牌所属类型不存在');
        }

        $fields = array(

            'brand_name' => I('post.brand_name', '', 'trim,htmlspecialchars'),
            'international' => I('post.international',1,'intval'),
            'type_value' => $type_value,


            'disorder'    =>	 	I('post.disorder',0,'intval'),
            'sendtime'		=>	I('post.sendtime',0,'strtotime'),
        );

        uppro('brand_image',$fields,'ajax');
        uppro('disc_img_path',$fields,'ajax');

        $this->logInsert = '添加品牌['.$fields['brand_name'].']';
        $this->logUpdate = '修改品牌['.$fields['brand_name'].']信息';
        return $fields;
    }

    //系列
    public function brand_models()
    {
        $brand_id = I('post.brand_id', 0, 'intval');
        if (! M('brand')->where('id='.$brand_id)->find()) {
            ajaxReturn(-1,'请选择一个存在的品牌');
        }


        $version = I('post.version', '', 'trim,htmlspecialchars');$version = trim($version, ',');
        $prod_color = I('post.prod_color', '', 'trim,htmlspecialchars');$prod_color = trim($prod_color, ',');
        $mirr_width = I('post.mirr_width', '', 'trim,htmlspecialchars');$mirr_width = trim($mirr_width, ',');
        $nose_width = I('post.nose_width', '', 'trim,htmlspecialchars');$nose_width = trim($nose_width, ',');

        $shape = isset($_POST['shape']) && is_array($_POST['shape'])?implode(',',$_POST['shape']):'';
        $style = isset($_POST['style']) && is_array($_POST['style'])?implode(',',$_POST['style']):'';




        $fields = array(

            'brand_id' => $brand_id,

            'version' => $version,
            'prod_color' => $prod_color,
            'mirr_width' => $mirr_width,
            'nose_width' => $nose_width,

            'shape' => $shape,
            'style' => $style,

            'disorder'    =>	 	I('post.disorder',0,'intval'),
            'sendtime'		=>	I('post.sendtime',0,'strtotime'),

        );

        $this->logInsert = '';
        $this->logUpdate = '车型修改';
        return $fields;
    }
    //product
    public function product()
    {
        $prod_brand = I('post.prod_brand', 0, 'intval');
        $prod_series = I('post.prod_series', 0, 'intval');
        if (! M('brand')->where('id='.$prod_brand)->find()) {
            ajaxReturn(-1,'请选择一个存在的品牌');
        }
        if (! M('brand_models')->where('id='.$prod_series)->find()) {
            ajaxReturn(-1,'请选择一个存在的品牌下的系列');
        }


        $market_price = I('post.price', '', 'trim,htmlspecialchars');

        $version = I('post.version', '', 'trim,htmlspecialchars');$version = trim($version, ',');
        $version or  ajaxReturn(-1,'请选择一个型号');

        $prod_color = I('post.prod_color', '', 'trim,htmlspecialchars');$prod_color = trim($prod_color, ',');
        $prod_color or  ajaxReturn(-1,'请选择一个色号');

        $mirr_width = I('post.mirr_width', '', 'trim,htmlspecialchars');$mirr_width = trim($mirr_width, ',');
        $mirr_width or  ajaxReturn(-1,'请选择一个镜框尺寸');

        $nose_width = I('post.nose_width', '', 'trim,htmlspecialchars');$nose_width = trim($nose_width, ',');
        $nose_width or  ajaxReturn(-1,'请选择一个鼻梁尺寸');

        $shape = I('post.shape', 0, 'intval');
        $shape or  ajaxReturn(-1,'请选择一个框型');

        $style = I('post.style', 0, 'intval');
        $style or  ajaxReturn(-1,'请选择一个款式');




        $fields = array(

            'prod_brand' => $prod_brand,
            'prod_series' => $prod_series,

            'version' => $version,
            'prod_color' => $prod_color,
            'mirr_width' => $mirr_width,
            'nose_width' => $nose_width,

            'market_price' => $market_price,

            'shape' => $shape,
            'style' => $style,

            'disorder'    =>	 	I('post.disorder',0,'intval'),
            'sendtime'		=>	I('post.sendtime',0,'strtotime'),

        );
//        print_r($fields);exit;

        uppro('img_path',$fields,'ajax');

        $this->logInsert = '';
        $this->logUpdate = '商品修改';
        return $fields;
    }




    //用户

	public function user()
	{

	    $name = I('name', '', 'trim,htmlspecialchars');
	    $username = I('username', '', 'trim,htmlspecialchars');
	    $password = I('password', '', 'trim,htmlspecialchars');

		if ($this->isInsert && M('user')->where("username='$username'")->find()) {


			ajaxReturn(-1,'账号已被使用,请更换新的');
		}

		$fields = array(

			'name' => $name,
			'username' => $username,
			'password' => $password,

		);

		$this->logInsert = '';

		$this->logUpdate = '用户修改';

		return $fields;



	}






}

