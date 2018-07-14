<?php
namespace App\model;

use PDO;

class SqlSrvModel
{
	public static $db = null; //sqlsrv数据库操作实例
	public static $instance = null;

		
    protected static $_data;
    private $_cache = [];
    protected $_dirty = false;
    /**
     * @var baseDAO
     */
    private $__where = [];
    private $dbInstance = null;
    protected $_pk;
	
	private $lastSql = '';//最后一次执行的sql语句

    public function __construct()
    {
		try
		{
			is_null(self::$db) && self::$db = new PDO("sqlsrv:Server=218.22.27.232,1433;Database=S3MEI","kws3mei","kws3mei123");
		}
		catch (PDOException $e)
		{
			throw new \Exception('Connection failed: ' . $e->getMessage());
		}
		
        $this->setDbInstance(self::$db);
    }
	
	public function query($sql)
	{
		$this->lastSql = $sql;
		$pdo_statement_object = $this->getDbInstance()->prepare($sql);
		$pdo_statement_object->execute();
		return $pdo_statement_object->fetch(PDO::FETCH_ASSOC);
	}
	
	public function _sql()
	{
		echo $this->lastSql;
	}
	
	/*
	public static function db()
	{
		is_null(self::$instance) && self::$instance = new self;
		
		return self::$instance->getDbInstance();
	}
	*/

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
    	    return static::$_data =  $this->getDbInstance()->where([$field=>$value])->find();
    	} elseif (strpos($method, 'where') === 0) {
            return $this->dynamicWhere($method, $parameters);
        }

        $className = __CLASS__;

        throw new \Exception("Call to undefined method {$className}::{$method}()");
    }

    //魔术方法__callStatic  
    public static function __callStatic($method,$parameters)
    {  
        if ($findIndex = strpos($method, 'findBy') === 0) {
        	$value = $parameters[0];
        	$field =  strtolower(substr($method, 6));
            return static::$_data =  $this->getDbInstance()->where([$field=>$value])->find();
        }

        $className = __CLASS__;

        throw new Exception("Call to undefined method {$className}::{$method}()");
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

    public function update($data, $id=null)
    {
        is_null($id) && $id = $this->id;
        return $this->getDbInstance()->update($data, static::TABLE, 'id='.$id);
    }

    public function select($field, $where, $order = 'id asc')
    {
        return $data = $this->getDbInstance()->select($field, static::TABLE, $where, $order);
    }

    public function selectOne($field, $where, $order = 'id asc') {
        return $data = $this->getDbInstance()->get_one($field, static::TABLE, $where, $order);
    }

    public function find($id, $field='*') {
        return $data = $this->getDbInstance()->get_one($field, static::TABLE, 'id='.$id, 'id asc');
    }

    public function count($where) {
        $res = $this->getDbInstance()->get_one('count(*) as count', static::TABLE, $where, $order);
        return $res['count'] ? $res['count'] : 0;
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