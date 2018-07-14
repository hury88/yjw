<?php
namespace App\controller;
class Controller {
    /**
     * @var string 视图名称
     */
    private $view;
    private $params;
    private $objects;
    private $_vars = [];
    private $config;

    protected $_data;

    protected $share = [];

    /**
     * @param $view
     * @param array $params
     * @param array $objects 直接引用对象
     */
    public function __construct(/*$view, $params=[], $objects=[]*/)
    {
    /*
        $this->view = $view;
        $this->params = $params;
        $this->objects = $objects;*/
    }

    /**
     * 获取Service|DAO
     * @param $obj
     * @return TXService | TXDAO
     */
    public function __get($obj)
    {
        if (substr($obj, -5) == 'Model') {
            $class = substr($obj, 0, -5);
            if (defined("$class::TABLE")) {
              return M($class::TABLE);
            } elseif(table_exists(lcfirst($class))) {
              return M(lcfirst($class));
            } else {
              E("`$class`类未定义表名称");
            }
        } else {
          return isset($this->_data[$obj]) ? $this->_data[$obj] : null;
        }
    }

    //display()方法
    protected function view($_file, $data = [])
    {
        $global = $GLOBALS;
        $unsets = ['_GET', '_POST', '_COOKIE', '_FILES', 'GLOBALS', '_SERVER', '_ENV'];
        foreach ($unsets as $var) {
          unset($global[$var]);
        }
        $data['bread'] = pc_bread();
        \Core\Blade::run($_file, array_merge($global, $data, $this->share));
    }
    //display()方法
    protected function mview($_file, $data = [])
    {
    	$_file = 'm.'.$_file;
        $global = $GLOBALS;
        $unsets = ['_GET', '_POST', '_COOKIE', '_FILES', 'GLOBALS', '_SERVER', '_ENV'];
        foreach ($unsets as $var) {
          unset($global[$var]);
        }
        $data['bread'] = pc_bread();
        \Core\Blade::run($_file, array_merge($global, $data, $this->share));
    }

    public function redirect($route, $arg=[])
    {
        header('Location:' . U($route, $arg));
        exit();
    }

    public function __call($method, $parameters)
    {
        throw new \BadMethodCallException("Method [{$method}] does not exist.");
    }
}
