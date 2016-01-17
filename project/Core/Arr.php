<?php   namespace Core;
 /**
  *  数组
  *
  *  提供数组操作
  *  
  * @author Sun <sunkang@wstaichi.com>
  * @license 私有，代码仅限内部使用。
  * @copyright 
  * @time 2014-2015
  */
class Arr
{
	static $to_str; 
	static $array_to_one;
	static $get_value;
	static $one_array;
	
	/**
	  * 对象转成数组
	  * @example  Arr::obj2arr($obj)   
	  * @param object $obj 　对象 
	  * @return 数组
	  */
	 static function obj2arr($obj){
		if(!$obj) return;
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val){
			$val=(is_array($val)) || is_object($val) ? static::obj2arr($val) :$val;
			$arr[$key] = $val;
		}
		return $arr; 
	}
	/**
	* 对array_combine优化
	* @param array $a  
	* @param array $b  
	*/
	static function array_combine($a=[],$b=[]){   
		 $i = 0;
		 foreach($b as $v){
		 	$out[$a[$i]] = $v;
		 	$i++;
		 } 
		 return $out; 
	}

	/**
 	  * 多维数组排序
	  * @example  Arr::deep( $arr,$keys,$type='asc'  )   
	  * @param array $arr 　 
	  * @param string $keys 　 
	  * @param string $type 　 默认值asc 或选值desc
	  * @return 数组
	  */
	function sort($arr,$keys,$type='asc'){ 
		  $keysvalue = $new_array = [];
		  foreach ($arr as $k=>$v){
		 	   $keysvalue[$k] = $v[$keys];
		  }
		  if($type == 'asc'){
		  	  asort($keysvalue);
		  }else{
			    arsort($keysvalue);
		  }
		  reset($keysvalue);
		  foreach ($keysvalue as $k=>$v){
		 	   $new_array[$k] = $arr[$k];
		  }
		  return $new_array; 
	} 
	
   
 

 
}
