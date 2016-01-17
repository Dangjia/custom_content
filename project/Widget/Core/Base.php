<?php 
namespace Widget\Core;
class Base{
	public $load;
	public $ele;
	public $par = [];
	public $script;
	public $scriptLink;
	public $css;
	public $cssLink;
	static $exists;
	public $option;
	public $version = 1.0;
	function __construct(){
		$this->init();
	}
	function init(){
		$this->option = $this->par['option'];
	}
	
	function toJson($arr){
		return json_encode($arr,JSON_PRETTY_PRINT);
	}

	function asssets($name){
		$dir = 'assets/'.$name.'/';
 		
		$to = WEB.'/'.$dir;
		if(!is_dir($to)){
			file_cpdir(__DIR__.'/'.$dir,$to);
		}
		return base_url().$dir;

	}
	
	static function render($name,$par = []){
		
		$over = "\Widget\Overwrite\\".ucfirst($name);
		$core = "\Widget\Core\\".ucfirst($name);
		
		if(class_exists($over)){
			$e = $over;
		}elseif(class_exists($core)){
			$e =  $core;
		}
		
		$obj = self::$exists[$e];
		if(!$obj){
			$obj = new $e;
			self::$exists[$e]  = $obj;
		}
		
		
		
		if($par){
			foreach($par as $k=>$v){
				$obj->$k = $v;
			}
		
		}
		if($obj){
			
			if(method_exists($obj,'load') && !$obj->load[$name]){
				$obj->load();
				$obj->load[$name] = true;
			}
			
			$obj->run();
		}
		
		self::$exists['_unique'][$name] = $obj;
		return self::$exists['_unique'];
	}
}