<?php
class View

{

	public static $data = [];// 当前类型信息

	public $error = false;



	public function __construct($id, $table)

	{

		if($id) {

			if ($data = M($table)->find($id)) {

				self::data($data);

			} else {

				$this->error = true;

			}

		} else {

			$this->error = true;

		}

	}



	public static function news($view, $tabalModel)

	{

		$id = $view->id;



		$controller = 'web';



		$tabalModel->where("`id`=$id")->setInc('hits');



		$pid = $view->pid;

		$ty = $view->ty;

		$view->date = date('Y-m-d', $view->sendtime);
		$view->time = date('H:i:s', $view->sendtime);

		$view->entime = date('F d, Y', $view->sendtime);

        $view->simg1 = src($view->img1);
        $view->simg2 = src($view->img2);
        $view->simg3 = src($view->img3);
        $view->simg4 = src($view->img4);
        $view->simg5 = src($view->img5);

		$view->content = $view->content ? htmlspecialchars_decode($view->content) : config('other.nocontent');

		$view->content2 = $view->content2 ? htmlspecialchars_decode($view->content2) : config('other.nocontent');

		$view->back = m_url($pid, $ty);



		#######上一篇下一篇 开始

		$prevOneNext = $tabalModel->field('id,title')->where("`pid`=$pid AND `ty`=$ty AND isstate=1")->order(config('order.order'))->select();

		$view->PreviousNext($prevOneNext,$id,$controller);

		unset($prevOneNext);

		#######上一篇下一篇 结束



		return $view;

	}



	public static function ktv($view, $tabalModel)

	{

		$id = $view->id;



		$controller = 'ktv';



		$tabalModel->where("`id`=$id")->setInc('hits');



		$pid = $view->pid;

		$ty = $view->ty;

		$view->time = date('Y-m-d', $view->sendtime);

		$view->entime = date('F d, Y', $view->sendtime);

		$view->img1 = src($view->img1);

		$view->content = htmlspecialchars_decode($view->content);

		$view->content2 = $view->content2 ? htmlspecialchars_decode($view->content2) : config('other.nocontent');

		$view->back = m_url($pid, $ty);



		#######上一篇下一篇 开始

		$prevOneNext = $tabalModel->field('id,title')->where("`pid`=$pid AND `ty`=$ty AND isstate=1")->order(config('order.order'))->select();

		$view->PreviousNext($prevOneNext,$id,$controller);

		unset($prevOneNext);

		#######上一篇下一篇 结束



        list($view->xiao_p1, $view->xiao_p2) = explode('|', $view->xiaobao);

        list($view->zhong_p1, $view->zhong_p2) = explode('|', $view->zhongbao);

        list($view->da_p1, $view->da_p2) = explode('|', $view->dabao);

		return $view;

	}

	public static function job($view, $tabalModel)

	{

		$id = $view->id;



		$controller = 'job';



		$tabalModel->where("`id`=$id")->setInc('hits');



		$pid = $view->pid;

		$ty = $view->ty;

		$view->time = date('Y-m-d', $view->sendtime);

		$view->entime = date('F d, Y', $view->sendtime);

		$view->img1 = src($view->img1);

		$view->content = htmlspecialchars_decode($view->content);

		$view->content2 = $view->content2 ? htmlspecialchars_decode($view->content2) : config('other.nocontent');

		$view->back = m_url($pid, $ty);



		#######上一篇下一篇 开始

		$prevOneNext = $tabalModel->field('id,title')->where("`pid`=$pid AND `ty`=$ty AND isstate=1")->order(config('order.order'))->select();

		$view->PreviousNext($prevOneNext,$id,$controller);

		unset($prevOneNext);

		#######上一篇下一篇 结束



        list($view->xiao_p1, $view->xiao_p2) = explode('|', $view->xiaobao);

        list($view->zhong_p1, $view->zhong_p2) = explode('|', $view->zhongbao);

        list($view->da_p1, $view->da_p2) = explode('|', $view->dabao);

		return $view;

	}



	public static function dispatch($id, $controller)

	{
        $controller = strtolower($controller);
		switch ($controller) {

			case 'ktv':

				$table = 'ktv';

				break;
            case 'mktv':

                $table = 'ktv';

                break;
			case 'job':

				$table = 'job';

				break;


            case 'mjob':

                $table = 'job';

                break;
			default:

				$table = 'news';

				break;

		}

		$tabalModel = M($table);

		$redirect_url = '/';

		$view = new View($id, $table);

		if ($view->error) {

			header('location:' . $redirect_url);

		}



		return self::$table($view, $tabalModel);

	}



	public static function goods(&$obj)

	{

		$obj->content = htmlspecialchars_decode($obj->content);

		$obj->title = v_news_cats($obj->category_id_1, 'catname') .'|'. v_id($obj->category_id_2, 'title') .'|'. $obj->goods_name;

		$obj->pid = 1;

		$obj->ty = $obj->category_id_1;

		return $obj;

	}









	public function PreviousNext($data,$id,$controller)

	{

		foreach ($data as $key => $row) {

		  if ($row['id']==$id) {

		    $previous = isset($data[$key-1]) ? $data[$key-1] : false;

		    $next = isset($data[$key+1]) ? $data[$key+1] : false;

		  }

		}

		$tpl_previous = '<li><a href="%s">%s</a></li>';

		$tpl_next = '<li><a href="%s">%s</a></li>';

		if($previous){

		  $url = U("$controller/detail", ['id'=>$previous['id']]);

		  $title = $previous['title'];

		}else{

		  $url = 'javascript:void(0);';

		  $title = '已经是第一篇';

		  // $title = 'Is already the first';

		}

		$this->previous = sprintf($tpl_previous,$url,$title);

		$this->previousLink = $url;

		$this->previousTitle = $title;

		//下一个

		if($next){

		  $url = U("$controller/detail", ['id'=>$next['id']]);

		  $title = $next['title'];

		}else{

		  $url = 'javascript:void(0);';

		  $title = 'Without';

		  $title = '没有了';

		}

		$this->next = sprintf($tpl_next,$url,$title);

		$this->nextLink = $url;

		$this->nextTitle = $title;

		unset($previous,$next,$tpl_previous,$tpl_next,$url,$title);

	}





	public function init()

	{

		self::data(M($table)->find($this->id));

	}



	public static function data($data)

	{

		array_walk($data, 'array_walk_decode');

		self::$data = array_merge(self::$data, $data);

		return self::$data;

	}



	public function __get($key)

	{

		return isset(self::$data[$key]) ? htmlspecialchars_decode( self::$data[$key] ) : '';

	}



	public function __set($key, $value)

	{

		self::$data[$key] = $value;

	}

}









