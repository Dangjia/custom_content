PHP5.5以上路由

安装

	composer require sunkangchina/php-log dev-master

如果使用 `read` `clean` 方法

    composer require sunkangchina/php-file dev-master

需要定义 

	define('WEB',__DIR__);  
	
启用日志,无参数时将启用所有级别的日志，如为数组将只启用对应的日志

	Log::open(['test']);  
	Log::info('test');
	Log::error('test');
	Log::read();
	
读取日志

		$r = Log::read();


清空日志

		Log::clean();



 
 
 