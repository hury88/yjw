<?php
//引导文件
namespace Core;
define('HURY', true);
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('CORE_PATH') or define('CORE_PATH', __DIR__ . DS);
defined('VENDOR_PATH') or define('VENDOR_PATH', CORE_PATH . '../vendor' . DS);
define('LIB_PATH', CORE_PATH . 'library' . DS);
define('LOG_PATH', CORE_PATH . 'logs' . DS);
defined('ROOT_PATH') or define('ROOT_PATH', dirname(CORE_PATH) . DS);
defined('PUBLIC_PATH') or define('PUBLIC_PATH', ROOT_PATH);// . 'public' . DS
defined('WEB_ROOT') or define('WEB_ROOT', ROOT_PATH . 'web_manage' . DS);
defined('APP_PATH') or define('APP_PATH', ROOT_PATH . 'app' . DS);
defined('UPLOAD_PATH') or define('UPLOAD_PATH', ROOT_PATH);//储存编辑文件
defined('VIEWS_PATH') or define('VIEWS_PATH', APP_PATH . 'views' . DS);//储存模板文件
defined('RUN_PATH') or define('RUN_PATH', APP_PATH . 'storage' . DS);//储存编辑文件

// defined('RUNNEED_PATH') or define('RUNNEED_PATH', CORE_PATH . 'runneed' . DS);
// defined('EXTEND_PATH') or define('EXTEND_PATH', CORE_PATH . 'extend' . DS);
defined('CONF_PATH') or define('CONF_PATH', ROOT_PATH . 'config.inc' . EXT); // 配置文件目录
// defined('CONF_EXT') or define('CONF_EXT', EXT); // 配置文件后缀
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);
// 载入Loader类
//require VENDOR_PATH . 'Loader.php';
require VENDOR_PATH . 'autoload.php';

// 注册自动加载
//Loader::register();

// 加载惯例配置文件
Config::set(include CONF_PATH);
//应用初始化
App::run();
