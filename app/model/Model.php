<?php
namespace App\model;

class Model
{
    protected $_data;
    public static $_cache = [];
    protected $_dirty = false;
    /**
     * @var baseDAO
     */
    private $__where = [];
    private $dbInstance = null;
    protected $_pk;


    public function __construct($id=null)
    {
        $this->dbInstance = M(static::TABLE);
        if ($id !== NULL){
            $this->_data = $this->dbInstance->find($id);
            $this->_pk = $id;
        }
    }

    /*
    public function _get($key)
    {
        $data = array_merge($this->_data, $this->_cache);
        return isset($data[$key]) ? $data[$key] : null;
    }
    */
    public function __get($key)
    {
        return isset(static::$_data[$key]) ? static::$_data[$key] : null;
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->_data)){
            $this->_data[$key] = $value;
            $this->_dirty = true;
        } else {
            $this->_cache[$key] = $value;
        }
    }

    public function __call($method, $parameters)
    {
        if ($findIndex = strpos($method, 'findBy') === 0) {
            $value = $parameters[0];
            $field =  strtolower(substr($method, 6));

            $parameters[1] = isset($parameters[1]) ? $parameters[1] : '*';
            return $this->_data =  $this->getDbInstance()->field($parameters[1])->where([$field=>$value, 'isstate'=>1])->find();
        } elseif (strpos($method, 'countBy') === 0) {

            $value = $parameters[0];
            $field =  strtolower(substr($method, 7));

            return $this->count("$field='$value'");

        } elseif (strpos($method, 'where') === 0) {
            return $this->dynamicWhere($method, $parameters);
        }

        $className = __CLASS__;

        throw new \Exception("Call to undefined method {$className}::{$method}()");
    }
    /**
     * 是否含有
     * @return mixed
     */
    public function isMatch($field, $value)
    {
        return
            isset($this->_data[$field]) &&
            $this->_data[$field] == $value;
    }

    /**
     * 是否存在
     * @return mixed
     */
    public function exist()
    {
        return self::$_data ? true : false;
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

    public function insert($data)
    {
        return $this->getDbInstance()->insert($data, static::TABLE, true);
    }

    public function update($data, $where="")
    {
        if(empty($where)) return false;
        return $this->getDbInstance()->where($where)->update($data);
    }

    public function select($field, $where, $order = NULL)
    {
        is_null($order) && $order = static::TABLE_ORDER;
        is_null($field) && $field = static::TABLE_FIELD;

        $data = $this->getDbInstance()->field($field)->where($where)->order($order)->select();

        return $data;
    }

    public function getField($field, $where, $order = NULL)
    {
        is_null($order) && $order = static::TABLE_ORDER;
        $data = $this->getDbInstance()->where($where)->order($order)->getField($field);

        return $data;
    }

    public function selectOne($field, $where, $order = NULL)
    {
        is_null($order) && $order = static::TABLE_ORDER;
        $data = $this->getDbInstance()->field($field)->where($where)->order($order)->find();
        return $data;
    }

    public function find($id, $field=null)
    {
        is_null($field) && $field = static::TABLE_FIELD;

        return $data = $this->getDbInstance()->field($field)->find($id);
    }

    public function count($where) {

        $count = $this->getDbInstance()->where($where)->count();
        return $count;
    }

    public function sum($field, $where) {
        $res = $this->getDbInstance()->get_one('sum('.$field.') as sum', static::TABLE, $where, $order);
        return $res['sum'] ? $res['sum'] : 0;
    }

    public function setDbInstance($db)
    {
        $this->dbInstance = $db;
    }
    public function getDbInstance()
    {
        return $this->dbInstance;
    }

}