<?php namespace Core;
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
*   Cache::switch('mem');
*	Cache::service([
*		    		['host'=>'127.0.0.1','port'=>11211,'weight'=>60]
*		    	]);
*	Cache::get($key);
*	Cache::set($key,$data = []);
*	Cache::increment($key,1);
*	Cache::decrement($key,1);
*	Cache::delete($key = null);
*</code>
*/ 
class CacheMem{ 
 	public $cache; 
 	public $active = false;
 	public $type = 'memcache';
 	static $obj;
 	static $pre; // 前缀
 	public function __construct( $servers = [] ) 
    {   
     	
    	if(!$servers){
	    	$servers =  [
	    		['host'=>'127.0.0.1','port'=>11211,'weight'=>60]
	    	];
    	} 
		if (extension_loaded('memcached')) {
			$this->type = "memcached";
			$this->cache = new \Memcached; 
			$this->active = true;
		}else if(extension_loaded ('memcache')){
			$this->cache = new \Memcache;  
			$this->active = true;
		}else{
			$this->active = false;  
			return;
		}
		foreach ($servers as $server)
		{
			$this->cache->addServer($server['host'], $server['port'], $server['weight']?:60);
		}   
    }
    
    static function init( $servers = [] ){
    	if(!isset(static::$obj))
    		static::$obj = new Static($servers);
    	return static::$obj;
    }
    
    
    /**
    	取得缓存值
    */
    static function get($key){  
    	if(true !== static::init()->active ) return false;
    	$key = static::$pre.$key; 
 		$data = static::init()->cache->get( $key );   
 		if($data == '#sun#kang#zhang#yi') return []; 
		return $data;
	} 
	/**
    	设置缓存，默认永不过期
    */
	static function set($key, $value, $minutes = 0){  
		if(true !== static::init()->active ) return false;
		$key = static::$pre.$key;
		if( $minutes > 0) {
			$minutes = time() + $minutes;
		} 
		if(!$value || (is_array($value) && count($value) < 1 )){
			$value = '#sun#kang#zhang#yi';
		}
		if(static::init()->type == 'memcache')
			static::init()->cache->set( $key, $value,false, $minutes ); 
		else
			static::init()->cache->set( $key, $value, $minutes ); 
	}
	/**
    	自增长缓存，默认步幅为1
    */
 	static function increment($key, $value = 1){   
  		if(true !== static::init()->active ) return false;
 		$key = static::$pre.$key;
 		return static::init()->cache->increment( $key );
 	}
 	/**
    	自减缓存，默认步幅为1
    */
 	static function decrement($key, $value = 1){ 
  		if(true !== static::init()->active ) return false;
 		$key = static::$pre.$key;
  		return static::init()->cache->decrement( $key );
 	}
 	/**
    	删除缓存，如果$key没有值 将清空所有缓存
    */
	static function delete($key = null){   
		if(true !== static::init()->active ) return false;
		if($key)
			$key = static::$pre.$key;
		if(!$key) static::init()->cache->flush( );
		static::init()->cache->delete( $key );
	}
 	
 	  
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );