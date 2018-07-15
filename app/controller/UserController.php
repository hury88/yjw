<?php
namespace App\controller;
use App\helpers\VerifyForm as VerifyForm;
use App\model\Person as Person;

class UserController extends Controller
{
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/index';

    public function index() {
        $person = Person::get();
        return $this->view('person', compact('person'));
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
    public function login()
    {

        if(isset($_POST['iswap'])) $this->redirectTo='/user/wap';
        $verify = [
            'username' => ['required', lang('login_username')],
            'password' => ['need', lang('login_password_empty')],
        ];

        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }
        #更新密码
        // $file = uppro_file('file', lang('pic.document'));

        #判断用户是否存在
        if ($user = Person::get()->has('username', $form->username, 'id,password,randcode')) {

            // if ($user['password'] == VerifyForm::md5($form->password, $user['randcode'])) {
            if ($user['password'] == $form->password) {
                Person::get($user['id'])->login();

                returnJson(200, lang('login_success'), $this->redirectTo);
            }
        }
        returnJson(-100, lang('login_failed'));
    }

    public function register()
    {
        $verify = [
            'username' => ['required', lang('login_username')],
            'password' => ['need', lang('login_password_empty')],
        ];

        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }
        #更新密码
        // $file = uppro_file('file', lang('pic.document'));

        #判断用户是否存在
        if ($user = Person::get()->has('username', $form->username, 'id,password,randcode')) {

            // if ($user['password'] == VerifyForm::md5($form->password, $user['randcode'])) {
            if ($user['password'] == $form->password) {
                Person::get($user['id'])->login();

                returnJson(200, lang('reg_failed'), $this->redirectTo);
            } else {

                returnJson(-100, lang('reg_failed'));
            }
        }else{
            $data=array(
                'isstate'=>1,
                'username'=>$form->username,
                'password'=>$form->password,
                'name'=>$form->username
            );
            if($insert = M('user')->insert($data) ) {
                Person::get($insert)->login();
                returnJson(200, lang('reg_success'),'/web/user');
            }else{
                returnJson(-100,'网络繁忙稍后再试！');

            }

        }
    }

    public function logout(){
        Person::get()->loginOut();
        \Core\response\Redirect::JsSuccess('确认退出...', '/index');
    }

    public function update(){
        $zdarr=explode('|',v_news(36,-38,'introduce'));
        $verify = [
            'z_0' => ['need', isset($zdarr[0]) ? $zdarr[0] : ''],
            'z_1' => ['need', isset($zdarr[1]) ? $zdarr[1] : ''],
            'z_2' => ['need', isset($zdarr[2]) ? $zdarr[2] : ''],
            'z_3' => ['need', isset($zdarr[3]) ? $zdarr[3] : ''],
            'z_4' => ['need', isset($zdarr[4]) ? $zdarr[4] : ''],
            'z_5' => ['need', isset($zdarr[5]) ? $zdarr[5] : ''],
            'z_6' => ['need', isset($zdarr[6]) ? $zdarr[6] : ''],
        ];
        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }


        $id = Person::get()->id;

        $user = Person::get()->has('id', $id, 'id,password,isstate');

        if (!$user || $user['isstate'] == 0) {

            returnJson(-100, '账户异常,请刷新页面重试。');
        }


        /*if ($user['password'] == VerifyForm::md5($form->password, $user['randcode'])) {
            Person::get($user['id'])->login();

            returnJson(200, lang('login_success'), $this->redirectTo);
        }*/

        $data  = [
            'z_0' => I('post.z_0', '', 'trim,htmlspecialchars'),
            'z_1' => I('post.z_1', '', 'trim,htmlspecialchars'),
            'z_2' => I('post.z_2', '', 'trim,htmlspecialchars'),
            'z_3' => I('post.z_3', '', 'trim,htmlspecialchars'),
            'z_4' => I('post.z_4', '', 'trim,htmlspecialchars'),
            'z_5' => I('post.z_5', '', 'trim,htmlspecialchars'),
            'z_6' => I('post.z_6', '', 'trim,htmlspecialchars'),
            'z_7' => I('post.z_7', '', 'trim,htmlspecialchars'),
            'z_8' => I('post.z_8', '', 'trim,htmlspecialchars'),
            'z_9' => I('post.z_9', '', 'trim,htmlspecialchars'),
            'z_10' => I('post.z_10', '', 'trim,htmlspecialchars'),
            'sendtime' => time(),
        ];
        #上传图片 居中裁剪
        $id = I('post.', '', 'trim,htmlspecialchars');
        if (Person::get()->M()->where(['id' =>$id])->setField($data)) {
//                _sql();
            returnJson(200, '信息修改成功');
        } else {
            returnJson(-100, '信息修改失败');
        }
    }
    public function updates(){
        $zdarr=explode('|',v_news(36,-38,'introduce'));
        $verify = [
            'z_0' => ['need', isset($zdarr[0]) ? $zdarr[0] : ''],
            'z_1' => ['need', isset($zdarr[1]) ? $zdarr[1] : ''],
            'z_2' => ['need', isset($zdarr[2]) ? $zdarr[2] : ''],
            'z_3' => ['need', isset($zdarr[3]) ? $zdarr[3] : ''],
            'z_4' => ['need', isset($zdarr[4]) ? $zdarr[4] : ''],
            'z_5' => ['need', isset($zdarr[5]) ? $zdarr[5] : ''],
            'z_6' => ['need', isset($zdarr[6]) ? $zdarr[6] : ''],
        ];
        $form = new VerifyForm($verify, 'post');
        #验证不通过
        if ($form->result()) {
            returnJson(-100, $form->error, $form->field);
        }
        $id =I('post.id', '', 'intval');
        $user = Person::get()->has('id', $id, 'id,password,isstate');

        if (!$user || $user['isstate'] == 0) {

            returnJson(-100, '账户异常,请刷新页面重试。');
        }


        $data  = [
            'z_0' => I('post.z_0', '', 'trim,htmlspecialchars'),
            'z_1' => I('post.z_1', '', 'trim,htmlspecialchars'),
            'z_2' => I('post.z_2', '', 'trim,htmlspecialchars'),
            'z_3' => I('post.z_3', '', 'trim,htmlspecialchars'),
            'z_4' => I('post.z_4', '', 'trim,htmlspecialchars'),
            'z_5' => I('post.z_5', '', 'trim,htmlspecialchars'),
            'z_6' => I('post.z_6', '', 'trim,htmlspecialchars'),
            'z_7' => I('post.z_7', '', 'trim,htmlspecialchars'),
            'z_8' => I('post.z_8', '', 'trim,htmlspecialchars'),
            'z_9' => I('post.z_9', '', 'trim,htmlspecialchars'),
            'z_10' => I('post.z_10', '', 'trim,htmlspecialchars'),
            'sendtime' => time(),
        ];
        #上传图片 居中裁剪

        if (Person::get()->M()->where(['id' =>$id])->setField($data)) {
//                _sql();
            returnJson(200, '信息修改成功');
        } else {
            returnJson(-100, '信息修改失败');
        }
    }
    /**
     * Handle the user login.
     *
     * @param Request $request
     *
     * @return void
     */
    protected function handle(Request $request, $rules)
    {

    }

    /**
     * Return the login validation rules.
     *
     * @return array
     */
    protected function rules($val)
    {
        if (strpos($val, '@')) {
            // 邮箱登陆
            $rules = [
                $this->getInputUsername() => 'required|email',
            ];
            $this->setCredentialsField('email');

        } else {
            // 手机登陆
            $rules = [
                $this->getInputUsername() => 'required|regex:/^1[34578][0-9]{9}$/',
            ];
        }

        $rules['password'] = 'required';

        return $rules;
    }

    /**
     * Return the user credentials.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->getCredentialsField() => $request->{$this->getInputUsername()},
            'password' => $request->password,
        ];
    }

    /**
     * Returns the login message error.
     *
     * @return string
     */
    public function getFailedLoginMessage()
    {
        return trans('user.credentials_do_not_match_our_records');
    }

    /**
     * 获取默认凭据字段
     * @return string
     */
    private function getCredentialsField()
    {
        return $this->credentialsField;
    }

    /**
     * 修改默认凭据字段
     */
    private function setCredentialsField($newField)
    {
        $this->credentialsField = $newField;
    }

    /**
     * 获取账户字段名
     * @return string
     */
    private function getInputUsername()
    {
        return 'username';
    }

    public function redirectTo()
    {
        if ($r = Request()->get('r')) {
            return base64_decode($r);
        }
        return $this->redirectTo;
    }
}
