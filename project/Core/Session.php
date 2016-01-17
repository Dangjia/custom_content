<?php   namespace Core;
/**
*  session 
*  
*  　　
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright  
* @time 2014-2015
*/
/** 
*<code> 
*	需要先session_start();
*	使用方法
*</code>
*
*/
class Session
{  
	static function init(){
		return new Crypt;
	}
	/**
	* 启动时session
	*/
	static function start(){
		session_start();
	} 
 	/**
	* 是否存在 flash message session 
	*
	* @param string $name 　 
	* @return  bool
	*/
	static function has_flash($name){ 
		$name = 'flash_message_'.$name;
		if(static::get($name))
			return true;
		return false;
	} 
	/**
	* 设置 flash message session 
	*
	* @param string $name 　 
	* @param string $value 　 
	* @return  string
	*/
	static function flash($name,$value = null){
		$name = 'flash_message_'.$name;
		if($value){		
			static::set($name,$value);
		}else{		 
			$value = static::get($name);  
	 		static::delete($name); 
		}
		return $value;
	}
	 
 	/**
	* 设置SESSION
	*
	* @param string $name 　 
	* @param string $value 　 
	* @return  string
	*/
	static function set($name,$value = null){  
		/**
		* 对数组或对象直接设置COOKIE
		*/
		if(!$value && (is_array($name) || is_object($name))){
			$name = (array)$name;
			foreach($name as $k=>$v){
				$_SESSION[$k] = static::init()->encode(Str::cookie($v));
			} 
			return $name;
		}
		if($value != null){
			$value = static::init()->encode(Str::cookie($value));
		}
		
		$_SESSION[$name] = $value;
	} 
	/**
	* 读取SESSION
	*
	* @param string $name 　 
	* @return  object/string
	*/
	static function get($name = null){
		if(!$name && $_SESSION) { 
			foreach($_SESSION as $k=>$v){ 
				$data[$k] = Str::re_cookie(static::init()->decode($v));
			} 
			return  (object)$data;
		} 
		elseif(is_array($name) && $_COOKIE) {   
			foreach($name as $k){
				$v = $_SESSION[$k]; 
				$data[$k] = Str::re_cookie(static::init()->decode($v));
			} 
			return  (object)$data;
		} 
		$value = $_SESSION[$name];
		if($value)
			return Str::re_cookie(static::init()->decode($value));		 
	} 
	/**
	* 删除SESSION,一个或多个或所有
	*
	* @param string $name 　 字符/数组/null
	* @return  void
	*/
	static function delete($name = null){
		if(!$name)
			$values = $_SESSION;
		elseif(is_array($name))
			$values = array_flip($name);
		if($values){
			foreach($values as $name=>$value){
				unset($_SESSION[$name]); 
			}
			return;
		}  
		unset($_SESSION[$name]); 
	}
	
	
 
}