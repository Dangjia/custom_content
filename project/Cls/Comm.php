<?php
namespace Cls;
class Comm{
	
	

	function admin_content_menu(){
	
		$r = file_find(BASE.'/project/Content');
		foreach($r['file'] as $v){
				
			if(strpos($v,'.php')!==false){
				$n = file_name($v);
				$n = substr($n,0,strrpos($n,'.'));
				$qi = '\Content\\'.$n;
				$b = new $qi;
	
				$menu[$b->title] = "/content/admin/index?q=".$n."|$n";
	
	
			}
				
		}
		return $menu;
	}
	
	
	/**
	 * 找到分页条并输出前部分内容
	 * @param unknown $str
	 */
	function b($str){
		$s = '<div style="page-break-after: always"><span style="display:none">&nbsp;</span></div>';
		if(strpos($str,$s)!==false){
			return explode($s,$str)[0];
		}
		return $str;
	}
	
	function config($key){
		$obj = obj('\Model\Config');
		log_info('no config setting key:'.$key);
		return $obj->get($key);
		
	}
	
	 
	
	function is_chinese($str){
		if (preg_match("/[\x7f-\xff]/", $str)) {
			return true;
		}
		return false;
	}
	
	function set_theme($key = 'AdminThemeTryChangeCSS',$value='admin_bootstrap_css'){
		
		$t = $_GET[$key];
		if(!$t){
			return;
		}
		$e = self::config($value);
		$obj = obj('\Model\Config');
		if($e){
			$obj->update(['title'=>$value],['value'=>$t]);
		}else{
			$obj->insert(['title'=>$value,'value'=>$t]);
		}
		
	}
	function set_admin_theme_css(){
		
		self::set_theme();
		self::set_theme('AdminThemeTryChange','admin_theme');
		
		
		
	}
	
	function download($src,$name){
		if(!$src){
			exit('参数错误');
		}
		$ext = substr($src,strrpos($src,'.')+1);
		if(!in_array($ext,['jpg','jpeg','png','gif','pdf'])){
			exit('该图不支持下载');
		}
		if(strpos($src,'http://')===false){
			$src = host().$src;
		}
		$ext = substr($src,strrpos($src,'.')+1);
		$arr = [
				'jpg'=>'jpeg',
				'png'=>'png',
				'gif'=>'gif',
				'pdf'=>'pdf',
		];
		$imgType = $arr[$ext]?:$ext;
		$name = $name.".".$ext;
	
	 	
		header('Content-type: '.$imgType);
	
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$filename = $name;
		$encoded_filename = urlencode($filename);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);
		if (preg_match("/MSIE/",$ua)){
			header('Content-Disposition: attachment; filename="'.$encoded_filename.'"');
		}elseif(preg_match("/Firefox/",$ua)){
			header('Content-Disposition: attachment; filename*="utf8\'\''.$filename.'"');
		}else{
			header('Content-Disposition: attachment; filename="'.$filename.'"');
		}
	
	
		$opts = [
				'http'=>[
						'method'=>'GET',
						'timeout'=>10
				]
		];
		$context = stream_context_create($opts);
	
		echo file_get_contents($src , false, $context);
		exit;//结束程序
	
	
	}
	
	
	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @return mixed
	 */
	function ip($type = 0)
	{
		$type      = $type ? 1 : 0;
		static $ip = null;
		if (null !== $ip) {
			return $ip[$type];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos = array_search('unknown', $arr);
			if (false !== $pos) {
				unset($arr[$pos]);
			}
			$ip = trim($arr[0]);
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$long = sprintf("%u", ip2long($ip));
		$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
		return $ip[$type];
	}
	/**
	 * 发送HTTP状态
	 * @param integer $code 状态码
	 * @return void
	 */
	function http($code)
	{
		static $_status = array(
				// Success 2xx
				200 => 'OK',
				// Redirection 3xx
				301 => 'Moved Permanently',
				302 => 'Moved Temporarily ', // 1.1
				// Client Error 4xx
				400 => 'Bad Request',
				403 => 'Forbidden',
				404 => 'Not Found',
				// Server Error 5xx
				500 => 'Internal Server Error',
				503 => 'Service Unavailable',
		);
		if (isset($_status[$code])) {
			header('HTTP/1.1 ' . $code . ' ' . $_status[$code]);
			// 确保FastCGI模式下正常
			header('Status:' . $code . ' ' . $_status[$code]);
		}
	}
	
}