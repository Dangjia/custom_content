<?php namespace Core;
use Core\Str,Core\File,Exception;
/**
*  Cache
*   
*  　　
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright 
* @time 2014-2015
*/  
/** 
* <code> 
*   Cache::switch('file');
*	Cache::get($key);
*	Cache::set($key,$data = []);
*	Cache::delete($key = null);
*</code>
*/ 
class CacheFile{ 
 	public $path;
 	static $path_set;
 	public $active = false;
 	static $pre; // 前缀
 	/**
 	* 非常重要,设置文件缓存路径，完整的路径　
 	*/
 	static function service($path = null){
 		if($path)
 		static::$path_set = $path;
 	}
 	/**
 	* $service 无需要使用　仅供统一调用　
 	*/
 	public function __construct() 
    {         
     	if(!static::$path_set){
 			$path = BASE.'/temp/cache';
 		}else{
 			$path = static::$path_set;
 		}
     	$top = File::dir($path.'.jpg');
     	if(!is_writeable($top)){
     		throw new Exception("文件缓存路径不可写".$top); 
     	}elseif(!is_dir($path)){
     		mkdir($path);
     	}
     	if(!is_dir($path)){
     		throw new Exception("文件缓存路径不存在".$path); 
     	} 
     	$this->path = $path;
     	$this->active = true;
    }
 
    /**
    	取得缓存值
    */
    function get($key){   
    	$a = $this->file($key); 
    	if(!file_exists($a[0])) return;
    	$data = file_get_contents($a[0]);
    	$time = file_get_contents($a[1]);
    	if($time<1){
    		$value = Str::re_cookie($data);
    	}elseif($time>0 ){
    		if(filemtime($a[0])+$time >= time()){    		
		 		$value = Str::re_cookie($data);
		 	}
		}
		if($value == '#sun#kang#zhang#yi') return [];
		return $value;
	}
	protected function file($key){
		$a = md5($key);
		$a1 = substr($a,0,1);
		$new = $this->path."/".$a1;
		if(!is_dir($new)) mkdir($new);
		$path = $new.'/'.$a;
		$url = $path.".txt";
		$url2 = $path.".bin";
		$url3 = $path.".md";
		return [$url,$url2];
	}
	/**
    	设置缓存，默认永不过期
    */
    function set($key, $value, $minutes = null){ 
    	if(!$minutes) $minutes = 0;
			$a = $this->file($key);
	    		if(!$value || (is_array($value) && count($value) < 1 )){
				$value = '#sun#kang#zhang#yi';
			}
			$value = Str::cookie($value);
			file_put_contents($a[0],$value);
			file_put_contents($a[1],$minutes);
		}
 	/**
    	删除缓存，如果$key没有值 将清空所有缓存
    */
	function delete($key = null){   
		if($key){
			$a = $this->file($key);  
			if(file_exists($a[0]))
				unlink($a[0]);
			if(file_exists($a[1]))
				unlink($a[1]);
		}else{
			File::rmdir($this->path);
		}
			
		
	}
 	
 	  
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );