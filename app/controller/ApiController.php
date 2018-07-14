<?php
namespace App\controller;

class ApiController extends Controller{

	public $method = 'GET';
	public $data = [];

	public function __construct(){

		/*if ($this->method == 'GET') {

			$this->data($_GET);
		} else {

			$this->data($_POST);
		}*/
		// $this->data = ${'_'.$this->method};
	}

    public function json($data){

        die( json_encode($data) );
    }

	/**
     * @desc 返回数据
     * @author hury
     * @wx hury88
     */
    private function jsonReturn($data, $status, $message){
        $return = array(
            'status' => $status,    /* 返回状态，200 成功，500失败 */
            'data' => $data,
            'message' => $message,
            'time' => date('Y-m-d H:i:s'),
        );
        echo json_encode($return);die;
    }

    /**
     * @desc 返回数据
     * @author hury
     * @wx hury88
     */
    public function success($data=[], $message=''){

        $this->jsonReturn($data, 200, $message);
    }


    /**
     * @desc 返回数据
     * @author hury
     * @wx hury88
     */
    public function error($message, $data=[]){

        $this->jsonReturn($data, 500, $message);
    }


}
