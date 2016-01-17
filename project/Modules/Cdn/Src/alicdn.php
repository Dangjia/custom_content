<?php
namespace Modules\Cdn\Src;
use AliyunClient;
use Cdn20141111RefreshObjectCachesRequest;
class alicdn{
	public $c;
	public $a;
	public $b;
	function __construct(){
		require_once __DIR__.'/aliyun-cdn-sdk/TopSdk.php';
		
		$c = new AliyunClient;
		
		$c->serverUrl = "http://cdn.aliyuncs.com/"; //根据不同
		
		$this->c = $c;
	}
	

	function init(){
		$c->accessKeyId = $this->a;
		$c->accessKeySecret = $this->b;
	}
	function refresh_dir($url){
		return $this->refresh_file($url,'Directory');
	}
	
	function refresh_file($url,$type="File"){
		//刷新缓存
		$req = new Cdn20141111RefreshObjectCachesRequest();
		$req->setObjectType($type); // File or Directory
		$req->setObjectPath($url);
		try {
			$resp = $this->c->execute($req);
			if(!isset($resp->Code))
			{
				//刷新成功
				return ($resp);
			}
			else
			{
				//刷新失败
				$code = $resp->Code;
				$message = $resp->Message;
				return $code.$message;
			}
		}
		catch (Exception $e)
		{
			// TODO: handle exception
		}
		
	}
	
	
	
}