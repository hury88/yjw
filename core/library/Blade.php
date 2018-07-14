<?php
namespace Core;
//操作数据库

//********************************************

//  作者：hury

//  时间：2017年11月26日17:02:17

//  作用：增加模板引擎 使用 laravel的模板引擎

//********************************************

class Blade
{
	public static function run($_file, $options = [])
	{
		$path = [VIEWS_PATH];         // 视图文件目录，这是数组，可以有多个目录
		$cachePath = RUN_PATH;     // 编译文件缓存目录

		$files = new \Xiaoler\Blade\Filesystem;
		$compiler = new \Xiaoler\Blade\Compilers\BladeCompiler($files, $cachePath);


		// 如过有需要，你可以添加自定义关键字
		/*$compiler->directive('datetime', function($timestamp) {
		    return preg_replace('/(\(\d+\))/', '<?php echo date("Y-m-d H:i:s", $1); ?>', $timestamp);
		});
*/
		$resolver = new \Xiaoler\Blade\Engines\EngineResolver;

		$resolver->register('blade', function () use($compiler){
		            return new \Xiaoler\Blade\Engines\CompilerEngine($compiler);
		});

		$finder = new \Xiaoler\Blade\FileViewFinder($files, $path);

		// 如果需要添加自定义的文件扩展，使用以下方法
		// $finder->addExtension('tpl');

		// 实例化 Factory
		$factory = new \Xiaoler\Blade\Factory($resolver, $finder);
		// 渲染视图并输出
		echo $factory->make($_file, $options)->render();
	}
}