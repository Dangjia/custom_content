<?php  
/**
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright 上海枫雪信息科持有限公司 
* @time 2014-2015
 */
namespace Core;

class Curl {
 	static $obj;
 	/** 
 	*	静态方法实现
 	*/ 
 	public static function __callStatic($name, $arguments) 
    {    
    	static::$obj = new CurlFunction;    
    	return call_user_func_array( array(static::$obj , $name) , $arguments);  
    } 
 	 
 	  
}
