<?php
namespace App\controller;

class TestController extends Controller{

	private $db = null;

    function __construct(){
    }

    /**
     * @desc 返回数据
     * @author wzh
     * @date 2017-02-19
     * @qq 646943067
     */
    private function jsonReturn($message, $status, $data){
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
     * @author wzh
     * @date 2017-02-19
     * @qq 646943067
     */
    private function success($message, $data){

        $this->jsonReturn($message, 200, $data);
    }


    /**
     * @desc 返回数据
     * @author wzh
     * @date 2017-02-19
     * @qq 646943067
     */
    private function error($message, $data){

        $this->jsonReturn($message, 500, $data);
    }


    /**
     * @desc 测试api接口 根据 班级id获取该班级下的所有学员
     * @author wzh
     * @version 1.0
     * @date 2017-02-19
     */
    public function getList(){
        $class_id = (int) $_GET['class_id'];
        $sql = " select student_id,student_name,gander from student where class_id = '$class_id' and is_delete = 0 ";
        $list = $this -> db -> getAll($sql);
        if(empty($list)){
            $this -> error('暂无数据');
        }
        $data['list'] = $list;
        $this -> jsonReturn($data);
    }

    /**
     * @desc 测试api接口 获取该学员 是否 已经打卡
     * @author wzh
     * @version 1.0
     * @date 2017-02-19
     * @qq 646943067
     */
    public function getSignStatus(){
        $student_id = (int) $_GET['student_id'];
        $time = time();
        $start_time = strtotime(date('Y-m-d',$time) . ' 00:00:00');
        $end_time = $start_time = 3600 * 24;
        $sql = " select status from student_status where student_id = '$student_id' ";
        $status = $this -> db -> getOne($sql);
        if($status == 1){
            $this -> success('已打卡');
        }else{
            $this -> error('未打卡');
        }
    }

}
