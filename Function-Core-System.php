<?php
$coreFun = BASE.'/project/function.php';
if(file_exists($coreFun)){
	include $coreFun;
}
boot();
function boot(){
	 
}

///////////////////////////////////////
// file
///////////////////////////////////////
use sunkangchina\phpfile\File;

function file_cpdir($dir, $to,$name = null){
	 File::cpdir($dir,$to,$name);
}

function file_find($dir,$find='*'){
	return File::find($dir,$find);
}

function file_rmdir($dir){
	File::rmdir($dir);
}
/**
 * 取文件名　返回类似 1.jpg
 *
 *
 * @param string $name
 * @return string
 */
function file_name($name){
	return File::name($name);
}
/**
 * 返回后缀 如.jpg
 *
 *
 * @param string $url 　
 * @return string
 */
function file_ext($url){
	return File::ext($url);
}

function file_class($class = null){
	return File::file_name($class);
}

function file_dir($url){
	return File::dir($url);
}


///////////////////////////////////////
// https://github.com/mawelous/yamop
// MongoDB 第三方COMPOSER类
///////////////////////////////////////

function mongo_connect($host,$dbName){
	$connection = new \MongoClient( $host );
	\Mawelous\Yamop\Mapper::setDatabase( $connection->$dbName );
}

function mongo($name){
	$m = new MongoModel;
	return $m->setConnect($name);
}

class MongoModel extends \Mawelous\Yamop\Model
{
	protected static $_collectionName;
	function setConnect($name){
		static::$_collectionName = $name;
		return $this;
	}
}


///////////////////////////////////////
// 过滤MONGODB ARRAY中的KEY为$的 $_GET POST COOKIE REQUEST
///////////////////////////////////////
function clean_mongo_array_injection(){
	$in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
	while (list ($k, $v) = each($in))
	{
		if(is_array($v)){
			foreach ($v as $key => $val)
			{
				if(strpos($key,'$')!==false){
					unset($in[$k][$key]);
					$key = str_replace('$','',$key);
				}
				$in[$k][$key] = $val;
				$in[] = & $in[$k][$key];
			}
		}
	}
}
clean_mongo_array_injection();

function redirect($url,$e301 = false){
	if($e301 === true){
		header( "HTTP/1.1 301 Moved Permanently" );
	}
	header("location:$url");
	exit;
}

function is_ajax(){
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	{
		return true;
	}
	else
	{
		return false;
	}
}

 

function d($str){
	print_r('<pre>');
	print_r($str);
	print_r('</pre>');
}


///////////////////////////////////////
//sunkangchina/php-* 核心类简化函数
///////////////////////////////////////

use  sunkangchina\phprouter\Route;
use  sunkangchina\phpview\View;
use  sunkangchina\phppdo\DB;
use  sunkangchina\phplog\Log;
use  sunkangchina\phppaginate\Paginate;

/**
 * 避免多次NEW
 * @param unknown $class
 * @return unknown
 */
function obj($class){
	static $m;
	if(!$m[$class]){
		$m[$class] = new $class;
	}
	return $m[$class];
}

function url($url,$par=[]){
	if(strpos($url,'.')!==false){
		if(substr($url,0,1)=='/'){
			$url = substr($url,1);
		}
		$link = $url;
		$hook = config('hook.url');
		$pre = base_url();
		if($hook){
			$pre = $hook($link);
		}
		return $pre.$link;
		
	}
	return Route::url($url,$par);
}

function base_url($fullUrl = true){
	$hook = config('hook.url');
	$pre = "/";
	if($hook){
		$pre = $hook($link);
	}
	return $pre;
}

function url_string(){
	return Route::string();
}
function host(){
	return Route::host();
}
function url_array(){
	return Route::controller();
}

function page($url,$count,$perSize = 10){
	$paginate = new Paginate($count,$perSize);
	$paginate->url = $url;
	$limit = $paginate->limit;
	$offset = $paginate->offset;
	return ['limit'=>$limit,'offset'=>$offset,'link'=>$paginate->show()];
}

function get($url,$fun){
	Route::get($url,$fun);
}

function post($url,$fun){
	Route::post($url,$fun);
}

function put($url,$fun){
	Route::put($url,$fun);
}

function delete($url,$fun){
	Route::delete($url,$fun);
}

function get_post($url,$fun){
	Route::all($url,$fun);
}

function view($file,$par = []){
	$view = View::make($file,$par);
	$hook = config('hook.view');
	if($hook){
		return $hook($view);
	}
	return $view;
}

function view_set($name,$value){
	return View::set($name,$value);
}

function view_cache($timeSecond = 3600){
	return View::cache($timeSecond);
}

function view_minify($flag = true){
	return View::$minify = $flag;
}


function view_module_path($path){
	View::$modulePath = $path;
}

function theme($name = null){
	return View::theme($name);
}

function theme_url($url = null){
	if($url && substr($url,0,1)!='/'){
		$url = '/'.$url;
	}
	return View::themeUrl().$url;
}

function log_open($par = []){
	Log::open($par);
}

function log_info($str){
	Log::info($str);
}

function log_sys($str){
	Log::system($str);
}

function log_error($str){
	Log::error($str);
}

function log_write($name,$str){
	Log::$name($str);
}

function log_read(){
	return Log::read();
}

function log_clean(){
	return Log::clean();
}
/**
 * DB::w(["mysql:dbname=cdn;host=127.0.0.1","test","test"])
 */
function db_connect($par = ["mysql:dbname=cdn;host=127.0.0.1","test","test"]){
	return  DB::w($par);
}
function db_connect_r($par = ["mysql:dbname=cdn;host=127.0.0.1","test","test"]){
	return  DB::r($par);
}
function db($name = null){
	return DB::w($name);
}
function dbr($name = null){
	return DB::r($name);
}





