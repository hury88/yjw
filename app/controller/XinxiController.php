<?php
namespace App\controller;
use App\helpers\VerifyForm as VerifyForm;
use App\model\Person as Person;

class XinxiController extends UserController
{
    public function index() {
        $person = Person::get();
        return $this->view('member', compact('person'));
    }
    public function password() {
        $person = Person::get();
        return $this->view('password', compact('person'));
    }
    public function zhuce() {
       // echo 123123;
        $this->view('zhuce');
    }

    public function ckxx() {
        $this->is_login = true;
        $id = isset($_GET['cid']) ? (int)$_GET['cid'] : '';
        $person = Person::get($id);
        return $this->view('ckxx', compact('person'));

    }

    public function register()
    {
        $verify = [
            'username' => ['need', ''],
            'z_1' => ['need', ''],
            'z_2' => ['need', ''],
            'z_3' => ['need', ''],
            'z_4' => ['need', ''],
            'z_5' => ['need', ''],
            'z_6' => ['need', ''],
        ];
        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }
        $z_7 = uppro_file('z_7', lang('pic.upload'));
        $z_8 = uppro_file('z_8', lang('pic.upload'));
        $z_9 = uppro_file('z_9', lang('pic.upload'));



        $data=array(
            'isstate'=>0,
            'username'=>$form->username,
            'name'=>$form->username,
            'z_0' => I('post.z_0', '', 'trim,htmlspecialchars'),
            'z_1' => I('post.z_1', '', 'trim,htmlspecialchars'),
            'z_2' => I('post.z_2', '', 'trim,htmlspecialchars'),
            'z_3' => I('post.z_3', '', 'trim,htmlspecialchars'),
            'z_4' => I('post.z_4', '', 'trim,htmlspecialchars'),
            'z_5' => I('post.z_5', '', 'trim,htmlspecialchars'),
            'z_6' => I('post.z_6', '', 'trim,htmlspecialchars'),
            'z_7' =>$z_7,
            'z_8' => $z_8,
            'z_9' => $z_9,
            'sendtime' => time(),
        );
        if($insert = M('user')->insert($data) ) {
            Person::get($insert)->login();
            returnJson(200, lang('reg_success'),'/index/index');
        }else{
            returnJson(-100,'网络繁忙稍后再试！');

        }
    }

    public function xxmm(){

        $verify = [
            'cust_old_pwd' => ['need',  ''],
            'cust_new_pwd' => ['need',  ''],
            'cust_pwd' => ['need',  ''],
        ];
        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }
        if ($form->cust_new_pwd!=$form->cust_pwd) {
            returnJson(-100,'两次输入密码不一致');
        }

        $id = Person::get()->id;

        $user = Person::get()->has('id', $id, 'id,password,isstate');

        if (!$user || $user['isstate'] == 0) {

            returnJson(-100, '账户异'.$user['id'].'常,请刷新页面重试。');
        }
        if($user['password']!=$form->cust_old_pwd){
            returnJson(-100, '原密码不正确！');
        }


        /*if ($user['password'] == VerifyForm::md5($form->password, $user['randcode'])) {
            Person::get($user['id'])->login();

            returnJson(200, lang('login_success'), $this->redirectTo);
        }*/

        $data  = [
            'password' => $form->cust_new_pwd

        ];
        if (Person::get()->M()->where(['id' =>$id])->setField($data)) {
//                _sql();
            returnJson(200, '密码修改成功');
        } else {
            returnJson(-100, '密码修改失败');
        }
    }


}
