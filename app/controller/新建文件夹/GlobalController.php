<?php
namespace App\controller;

class GlobalApiController extends Controller{

	public $method = 'GET';
	public $data = [];

	public function __construct(){

		if ($this->method == 'GET') {

			$this->data($_GET);
		} else {

			$this->data($_POST);
		}
		// $this->data = ${'_'.$this->method};
	}

	public function PUB($config, $order = ''){
		$init = array(
			'field' => '*',
			'map' => [],
			'table' => 'news',
			'limit' => 0,
			'json' => true,
		);

		$config = array_merge($init, $config);

		$config['map']['isstate'] = 1;

		$m = M($config['table'])->field($config['field'])->where($config['map'])->order(($order?:config('other.order')));

		if ($init['limit']) {

		    $m = $m->limit($init['limit']);
		}

		$data = $m->select();

		if($config['json']) {

			return $this->Json($data);
		}
		return $data;

	}

	public function PUBOne($config){

		$init = array(
			'field' => '',
			'map' => [],
			'table' => 'news',
			'json' => true,
		);


		$config = array_merge($init, $config);

		$config['map']['isstate'] = 1;

		$result = v_id($config['map']['id'], $config['field'], $config['table']);

		if($config['json']) {

			return $this->Json($result);
		}
		return $result;

	}

	public function Json($data, $die = true)
	{

		$status = (array) $data ? 1 : 0;

		if ($die) {

			die( json_encode(['data' => $data, 'status' => $status]) );
		}

		return json_encode(['data' => $data, 'status' => $status]);
	}

	public function data($data)
	{
		$this->data = (array) $data;
	}


	/*
		--------------------数据库操作
	 */
	public function isExist()
	{
		$id = isset($this->data['id']) ? intval($this->data['id']) : 0;

		return $this->Json( $this->find($id) );
	}

	protected function find($map, $field = '*')
	{
		if (is_numeric($map)) {
			$map = ['id' => $map];
		}

		if ($field == '*' || strpos($field, ',')) {

			return M(static::TABLE)->where($map)->field($field)->find();
		}
		return M(static::TABLE)->where([$map])->getField('id');
	}

	protected function update($map, $data)
	{
		return M(static::TABLE)->where($map)->update($data);
	}

	protected function insert($data)
	{
		return M(static::TABLE)->insert($data);
	}

}
