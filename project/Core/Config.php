<?php   namespace Core;
/**
*  Config 读取/设置　 config/*.php 中的内容
*
*  
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright  
* @time 2014-2015
*/

/**
*    
*
*<code>
*设置配置的路径，可以不设置．默认路径BASE.'/config'
*Config::path(WEB.'/../config/');
*
*读取
*Config::get('app.error_reporting'); 
*
*</code>
*　
*/  
class Config{ 
	
	static $_config;
	static $path;
	/**
	* 设置配置所在的文件夹
	* @example  Config::path($path)   
	* @param string $path  
	* @return void
	*/
	static function path($path){
		if(!isset(static::$path))
			static::$path = $path; 
	}
	/**
	* 取配置值，支持多级配置读取,使用.分隔
	* @example  Config::get($alias)   
	* @param string $alias  
	* @return string/array
	*/
	static function get($alias){
		return static::load($alias);
	}
	/**
	* 设置配置值
	* @example  Config::set($alias,$value)   
	* @param string $alias 　 
	* @param string $value 　 
	* @return  void
	*/
	static function set($alias,$value){
		 $id = md5($alias);
		 static::$_config[$id] = $value; 
	}
	/**
	*　内部函数,不建议使用
	*/
	static function load($alias){  
		$id = md5($alias);
		if(static::$_config[$id]) return static::$_config[$id];
		if(strpos($alias , '.') !== false){
			$key = substr($alias,strpos($alias , '.')+1); 
			$alias = substr($alias,0,strpos($alias , '.'));   
		}
		if(!isset(static::$_config[$id])){
			$path = static::$path?:BASE.'/config/'; 
			$file = $path.str_replace('.','/',$alias).'.php';  
			if(file_exists($file)){ 
				static::$_config[$id] = include $file;
			}  
		}  
		$value = static::$_config[$id]; 
		if($key){ 
			if(strpos($key , '.') !== false){  
				$arr = explode('.',$key);  
				foreach($arr as $v){
					$value = $value[$v];
				}   
				static::$_config[$id] = $value;
				return $value; 
			}
			static::$_config[$id] = $value[$key];
			return $value[$key];
		}
		static::$_config[$id] = $value;
		return $value;
	}
  

}
