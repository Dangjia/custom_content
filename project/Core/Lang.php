<?php   namespace Core;
/**
*  多语言 
*  
*  　　
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright  
* @time 2014-2015
*/
/** 
*<code>
*  加载要翻译的包,默认 messages/zh_CN/app.php
*
*Lang::init($path)->load('app');
*	
* 该函数已经在functions.php定义好了
*
*function __($key,$alias='app'){ 
*	return Lang::get($key,$alias); 
*} 
*
*</code>
*	  
*/
class Lang
{ 
	/**
	*语言包路径	
	*/
 	protected $dir;
 	/**
	* 当前的语言
	*/
 	static $lang = 'zh_CN';
 	/**
	* 对象	
	*/
 	static $obj;
 	static $init;
 	/**
	* 构造函数
	*/
	function __construct($path = null){
		if(!$path)
	 		$this->dir = BASE.'/messages';			
	 	else
	 		$this->dir = $path;
	} 
	/**
	* 加载要翻译的包
	*
	* @param string $alias 　 
	* @return  void
	*/	
	function load($alias='app'){
		if(!static::$obj[static::$lang][$alias]){
			$file = $this->dir.'/'.static::$lang.'/'.$alias.'.php';
			if(file_exists($file)){
				static::$obj[static::$lang][$alias] = include $file;
			}
		}
	}
	/**
	*  初始化
	*/	
	static function init(){
		if(!isset(static::$init)){
			static::$init = new Static;
		}
		return static::$init;
	}
	 
	/**
	* 取得翻译
	*
	* @param string $key 　 
	* @param string $alias 　 
	* @return  string
	*/	 	
	static function get($key , $alias = 'app'){
		return static::$obj[static::$lang][$alias][$key]?:$key;
	}
	
	
	 
     
   
   
}
