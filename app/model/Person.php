<?php
namespace App\model;

class Person extends Model
{
    const TABLE = 'user';
    public static $_cache = [];
    public $is_login = false;

    protected $_data;
    /**
     * @var baseMD
     */
    protected $MD;
    protected $_pk;

    /**
     * @param null $id
     * @return Person
     */
    public static function get($id=null)
    {
        $id = $id ?: self::getUserId();
        if (!isset(self::$_cache[$id])){
            self::$_cache[$id] = new self($id);
        }
        return self::$_cache[$id];
    }

    public function __construct($id)
    {
        
        $this->MD = M(self::TABLE);
        if ($id !== NULL){
            $this->_data = $this->MD->find($id);
            $this->_pk = $id;
        }
    }

    public function M()
    {
        return $this->MD;
    }

    /**
     * 是否含有
     * @return mixed
     */
    public function has($field, $value, $select = '*')
    {
        return $this->MD->field($select)->where([$field=>$value])->find();

    }
    /**
     * 是否含有
     * @return mixed
     */
    public function notHas($field, $value)
    {
        return ! $this->MD->where([$field=>$value])->find();
    }

    /**
     * 是否存在
     * @return mixed
     */
    public function exist()
    {

        return $this->_data ? true : false;
    }

    /**
     * 获取键值
     * @return mixed
     */
    public function getPk()
    {
        return $this->_pk;
    }

    /**
     * 获取用户数据
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * 获取用户Id
     */
    public static function getUserId()
    {
        return isset($_SESSION['webUserId']) ? $_SESSION['webUserId'] : null;
    }
    /**
     * 设置用户Id
     */
    public static function setUserId($id)
    {
        $_SESSION['webUserId'] = $id;
    }

    public function isLogin()
    {
        return ! is_null(self::getUserId());
    }
    /**
     * 登录
     */
    public function login()
    {
        $data  = [
            'lastloginip'    => request()->ip(),
            'lastlogintime'  => time(),
            'logtimes' => ['exp', 'logtimes+1'],
        ];
        $result =  $this->MD->where(['id' => $this->_pk])->update($data);

        self::setUserId($this->_pk);
        $this->is_login = true;
    }

    /**
     * 登出
     */
    public function loginOut()
    {
        self::setUserId(null);
        $this->is_login = false;
    }
}