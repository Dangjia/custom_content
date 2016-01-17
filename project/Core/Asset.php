<?php   namespace Core;
/**
  *  Asset 资源管理
  *
  *  生成css js 链接，在Widget中更加实用
  * 
  * @author Sun <sunkang@wstaichi.com>
  * @license 私有，代码仅限内部使用。
  * @copyright 
  * @time 2014-2015
  */
/**
*
*<code>
*　Asset::$debug = true;
*　<link href="<?php echo Asset::css(Config::get('asset.css.admin'));?>" rel="stylesheet">  
*　<script src="<?php echo Asset::js(Config::get('asset.js.admin'));?>"></script>
*</code>
*
*/
class Asset
{
	/**
	*　调试，打开后如 $minify也为true　对生成压缩的文件　每次都会生成　
	*　正式环境中　请勿设置该值
	*/
	static $debug = false;
	/**
	* 压缩文件　使用　yuicompressor.jar
	*/
	static $minify = false;
	/**
	* 生成在public目录下的 $name　中
	*/
	static $name = 'assets';
	/**
	* 输出css
	*  
	* @example 
	*
	*<code>
	*
	*	Asset::css(['jquery']);
	*
	*</code>
	* @param array $files  
	* @param string $name　　
	* @return int
	*/
	static function css($files = [],$name = null){
		return static::run($files,'css',$name);		
	}
	/**
	* 输出js
	*  
	* @example 
	*
	*<code>
	*
	*	Asset::js(['jquery']);
	*
	*</code>
	* @param array $files   
	* @param string $name　　
	* @return int
	*/
  	static function js($files = [],$name = null){
		return static::run($files,'js',$name);		
	}
	/**
	*  内部函数 
	 
	*/
 	static function run($files = [],$type='css' ,$names = null){ 
 		if(static::$minify!==false){
 			foreach($files as $file){
 				if($type=='css')
					$str .='<link type="text/css" rel="stylesheet" href="'.$file.'" />';
				else
					$str .='<script type="text/javascript" src="'.$file.'"></script>';
			}
 			
 			return $str;
 		}
		$jar = "java -jar ".realpath(__DIR__.'/resource/').'/yuicompressor.jar';
		$dir = WEB."/".static::$name."/file/";
		if(!is_dir($dir)) mkdir($dir);
		$jar .= "  --type $type -o ".$dir;   
		if(!$names) $names = md5(implode('',$files)).'.'.$type;
 		$names = '/'.static::$name.'/'.strtolower($names);
 		$output = WEB.$names;
 		if(file_exists($output) && static::$debug === false) goto end;
		foreach($files as $file){
			if(!file_exists($file)) $file = WEB.'/'.$file;
			if(!file_exists($file)) continue;
			$name = md5($file).'.'.$type;
			$exec = $jar.$name." ".$file;
			$d[$name]  = $dir.$name;  
			exec($exec);
		}
		@unlink($output);
		$h = fopen($output,"a"); 
		foreach($d as $v){ 
			 $data = static::clean(file_get_contents($v)); 
			 @unlink($v);
			 fwrite($h,$data);
		}
		fclose($h);
		end:
		return $names; 
	}
	/**
	* 压缩data
	*  
	* @example 
	*
	*<code>
	*
	*	Asset::clean(html);
	*
	*</code>
	* @param string $data 
	* @return string
	*/
	static function clean($data){
		$data = str_replace("\t", "", $data);  
		$data = str_replace("\r\n", "", $data); 
		$data = str_replace("\n", "", $data); 
		$data = preg_replace("/\/\/\s*[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/", "", $data); 
		$data = preg_replace("/\/\*[^\/]*\*\//s", "", $data);
		return $data;
	}
	
	
 
}
