<?php
require_once __DIR__.'/app/common.incs.php';
header("X-Powered-By:http://godness.cc");

if (isset($analogUri)) {// 静态页使用

	$requestUri = $analogUri;

} else {

	$requestUri = request()->url();

}

$namespace = '\\App\\controller\\';

// 路由解析 model或者controller
list($controller, $method) = \Core\Config::route($requestUri);//echo $controller, '----', $method;

define('IS_INDEX',$method == 'index');
define('CONTROLLER', $controller);
define('METHOD', $method);

// 引入业务处理代码

//require_once __DIR__.'/app/processing.php';
//$person = \App\model\Person::get();

$controllerClassName = $namespace . ucfirst($controller) . 'Controller';
if (class_exists($controllerClassName) && method_exists($controllerClassName, $method)) {

    //$octrl = new $controllerClassName();
    $ReflectionMethod = new \ReflectionMethod($controllerClassName, $method);
    $parameters = $ReflectionMethod->getParameters(); // 参数对象数组
    //$parametersNumber = $ReflectionMethod->getNumberOfParameters(); // 参数个数
    $depend = array();

    foreach ($parameters as $value) {

        if(isset(${$value->name})){
            array_push($depend, ${$value->name});
        } else {

            array_push($depend, I($value->name, ''));
        }
    }

    $ReflectionMethod->invokeArgs(new $controllerClassName(), $depend);

    //call_user_func_array([$octrl,$method], [$id, $sid, $pid]);

} else {

	die(config('r404'));

}
