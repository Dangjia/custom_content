<?php   namespace sunkangchina\phplog;
use  sunkangchina\phpfile\File;
/**
*  Log日志 
*  
*  　　
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright http://www.wstaichi.com 
* @time 2014-2015
*/
/**
*<code>
*需要定义 define('WEB',__DIR__);  
*	
*启用日志,无参数时将启用所有级别的日志，如为数组将只启用对应的日志
*
*Log::open(['test']);  
*   
*
*Log::info('test');
*Log::error('test');
*Log::read();
*	
*Route:
*
*	Route::get('log',function(){
*		$r = Log::read();
*		dump($r);
*	});
*
*	Route::get('clean',function(){
*		Log::clean();
*	});
*
*</code>
*/
class Log{
	static $path;  
	/**
	*是否开启日志 ，默认开启
	*/
	static $open = false;
	static $enable;
	static $object;
	
	static function close(){
		static::$open = false;
	} 
	/**
	* 启用日志
	*
	* @param array $arr 　 
	* @return  void
	*/	
	static function open($arr = null ){
		if(!isset(static::$object)){
			static::init();
			static::$object = true;
		}
		static::$open = true;
		if($arr)
			static::$enable = $arr;
	}
 	/**
	* 初始化
	*/
 	static function init(){
 		if(static::$path) return;
 	    $path = BASE.'/runtime/logs'; 
 		if(!is_writable($path)){
	 		$root = substr($path,0,strrpos($path,'/'));
	 		exec("chmod 777 $root");
 		}  
 		if(!is_dir($path)) { 
 			mkdir($path, 0777, true);
 		} 
 		static::$path = realpath($path);  
 	}  
 	/**
	* 读取所有日志
	*
	* @param string $name 　 
	* @return  array
	*/
 	static function read($name = null){
 		if(static::$open===false) return;
 		$dir = static::$path;
 		if($name){
 			$name = ucfirst($name);
 			$dir = $dir.'/'.$name;
 		} 
 		$list = File::find($dir);
		if($list['file']){
			foreach(array_reverse($list['file']) as $v){
				$k = str_replace(static::$path,'',$v);
				$content = file_get_contents($v); 
				$out .= "<h3>".$k."</h3>".$content."\n\n";
			}
		}
 		return $out;
 	}
 	/**
	* 清空日志
	*
	* @param string $name 　 
	* @return  void
	*/
 	static function clean($name = null){
 		if(static::$open===false) return;
 		$dir = static::$path;
 		if($name){
 			$name = ucfirst($name);
 			$dir = $dir.'/'.$name;
 		}  
		File::rmdir($dir);
 	}
 	/**
	* 写json格式的日志
	*
	* @param string $arr 　 
	* @param string $name 　 
	* @return  void
	*/
 	static function json($arr , $name = null){
 		if(!$name) $name = 'json';
 		static::write($name,json_encode($arr));
 	}
 	/**
	* 内部函数，写文件
	*
	* @param string $type 　 
	* @param string $str 　 
	* @return  void
	*/
 	static function write($type = 'info',$str ,$w = false){ 
 		if(static::$open===false) return;
 		if(!$str) return ; 
 		if(false === $w && static::$open !== true) return ;
 		if(static::$enable && !in_array(strtolower($type),static::$enable)) return; 
 		$type = ucfirst($type);
 		$dir = static::$path.'/'.date("Y").'/'.date('m');
 		if(!is_dir($dir)) {
 			if (!mkdir($dir, 0777, true)) { 
 				static::init(); 
		    }
 		}
  		$filename = $dir.'/'.date("dH").".log";
  		if(is_object($str )) $str  = Arr::object2array($str) ; 
 		if(is_array($str)) {
 			unset($new);
 			foreach($str as $k=>$v){
 				$k1[] = $k;
 				$v1[] = $v; 
 			}
 			if(!file_exists($filename)){
	 			foreach($k1 as $v){
	 				if(is_object($v)) $v= (array)$v;
	 				if(is_array($v)) $v = json_encode($v);
	 				$new .= $v."\t"; 
	 			}
	 			$new .= "\r";
 			}
 			foreach($v1 as $v){
 				if(is_object($v)) $v= (array)$v;
 				if(is_array($v)) $v = json_encode($v);
 				$new .= $v."\t"; 
 			} 
 			$str = $new;
 		}  
 		if(!$str) return;  
 		try{
 			$fh = fopen($filename, "a+");
 			$str = "[".$type."] ".$str."\t [".date('Y-m-d H:i:s')."]\n";
			fwrite($fh, $str);
			fclose($fh);
 		}catch(Exception $e) { 
		    
		} 
		 
 	}
 	/**
	* 静态方法
	*/
 	static function __callStatic ($name ,$arg = [] ){ 
 		 $str = $arg[0];  
 		 if(is_array($str) && count($str)>1){$str = implode(" ",$str);}  
 		 if(strtolower(substr($name,0,4))=='json'){ 
 		 	$name = substr($name,4); 
 		 	static::json($str,$name);
 		 	return ;
 		 }
 		 static::write($name , $str);
	}
 	  
}