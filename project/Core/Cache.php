<?php   namespace Core;
/**
*  Cache
*   
*  　　
* 
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright 
* @time 2014-2015
*/  
/** 
* <code>
*  默认用memcache缓存,程度自动判断，如没有memcache将尝试使用file文件缓存
* 
*	Cache::service([
*		    		['host'=>'127.0.0.1','port'=>11211,'weight'=>60]
*		    	]);
*	Cache::get($key);
*	Cache::set($key,$data = []); 
*	Cache::delete($key = null);
*</code>
*/  
class Cache{ 
	static $obj;
	
	/**
	* 可使用Cache::swtich();选缓存方式 file mem
	*<code>
	*Cache::swtich();
	*</code>
	*/
	static $w = "mem";
	static $service;
	static $pre; // 前缀
	/**
	* 设置cache的前缀
	*/
	static function set_key($w){
		static::$pre = $w;
	}
	/**
	* 可选缓存 file mem
	*/
	static function swtich($w = 'mem'){
		static::$w = $w;
	}
	
	/**
 	* 非常重要,设置文件缓存路径，完整的路径　
 	*/
 	static function service($path = null){
 		if($path)
 			static::$service = $path;
 	}
 
    static function init(){
    	if(!static::$obj[static::$w]){ 
			$cache = "\src\Cache".ucfirst(static::$w);
	    	static::$obj[static::$w] = new $cache(static::$service);
    	} 
    	if(static::$obj[static::$w]->active!==true) {
			static::$w = "file";
			$cache = "\src\Cache".ucfirst(static::$w);
	    	static::$obj[static::$w] = new $cache(static::$service);
    	} 
    	$r = static::$obj[static::$w];
    	$r::$pre = static::$pre;
    	return static::$obj[static::$w];
    }
    /**
    	取得缓存值
    */
    static function get($key){  
     	return static::init()->get($key);
	} 
	/**
    	设置缓存，默认永不过期
    */
	static function set($key, $value, $minutes = 0){  
	 	return static::init()->set($key, $value, $minutes);
	}
 
 	/**
    	删除缓存，如果$key没有值 将清空所有缓存
    */
	static function delete($key = null){   
		 	return static::init()->delete($key);
	}
 	
 	  
}
