<?php   namespace Core;
/**
*  CURL
*
*   
*  
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright  
* @time 2014-2015
*/
/**  
*<code>	
*$curl = Curl::init();
*$curl->header = true;
*$g = $curl->get($url);
* 
* 
*  
*Curl::get($url);
*Curl::post($url,$data);
* 
*
*
*Curl  注意当 https://请求时，如果不小心在url前有空格会有问题，
*所以该类trim($url) 解决这个问题 
*更多选项设置：	
*CURLOPT_HEADER 
*CURLOPT_NOBODY
*CURLOPT_REFERER
*CURLOPT_COOKIEJAR
*CURLOPT_COOKIEFILE
*CURLOPT_RETURNTRANSFER
*CURLOPT_FOLLOWLOCATION
*CURLOPT_COOKIE: 传递一个包含HTTP cookie的头连接。 
*</code>
*/ 
class CurlFunction{
 	public $option;
	public $agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.66 Safari/537.36";
	public $timeout = 300; 
	private $curl;
	public $data;
	static $info;
	public $connect = 120;
	public $header = false;
	public $cookie = false;
	public $cookie_file;
	public $nobdy = false;
 	public function __construct(){ 
		if(!extension_loaded ('curl')){ 
    		throw new \Exception('CURL not installed');
    	}
		$this->curl = curl_init();  
 		$this->option[CURLOPT_TIMEOUT] = $this->timeout;
 		$this->option[CURLOPT_CONNECTTIMEOUT] = $this->connect;
 		$this->option[CURLOPT_SSL_VERIFYPEER] = false;
 		$this->option[CURLOPT_SSL_VERIFYHOST] = false;   
 		$this->option[CURLOPT_SSLVERSION] = false;  
 		$this->option[CURLOPT_FOLLOWLOCATION] = 1;  
 		$this->option[CURLOPT_USERAGENT] = $this->agent;  
 		//返回字符串，而非直接输出
 		$this->option[CURLOPT_RETURNTRANSFER] = 1;  
	} 
 	public function set($type,$value){
 		$this->option[$type] = $value;
 	}
 	function get($url,$options = null , $obj = false){ 
 		if($options === true){
 			$obj = true;
 			unset($options);
 		} 
 		$info = $this->_get($url,$options);
 		if(true === $obj) return $this; 
 		curl_close($this->curl);
 		return $info;
 	}
 	function post($url,$data ,$options = null, $obj = false){ 
 		if($options === true){
 			$obj = true;
 			unset($options);
 		} 
 		$info = $this->_post($url,$data ,$options);
 		if(true === $obj) return $this;
 		curl_close($this->curl);
 		return $info;
 	}
 	 

 	/**
 	*内部函数
 	*/
 	private function _get($url,$options = []){ 
 		if(is_array($options)){
 			foreach($options as $k=>$v){
 				$this->option[$k] = $v;
 			}
 		} 
 		return $this->run($url);
 	}
 	/**
 	*内部函数
 	*/
 	private function _post($url,$data ,$options = []){ 
 		$this->option[CURLOPT_POST] = true;
 		$this->option[CURLOPT_POSTFIELDS] = $data;
 		$this->option[CURLOPT_CUSTOMREQUEST] = "POST"; 
 		//解决 POST 数据过长问题
 		$this->option[CURLOPT_HTTPHEADER] = ['Expect:'];   
 		if(is_array($options)){
 			foreach($options as $k=>$v){
 				$this->option[$k] = $v;
 			}
 		} 
 		return $this->run($url);
 	} 
  	/**
 	*内部函数
 	*/
    private function run($url){      
    	if(true === $this->header)
    		$this->option[CURLOPT_HEADER] = 1; 
 		curl_setopt($this->curl,CURLOPT_URL,trim($url));   
 		foreach($this->option as $k=>$v){  
 			curl_setopt ( $this->curl , $k, $v);
 		}     
 		$this->data = curl_exec($this->curl);  
 		static::$info = curl_getinfo($this->curl);  
 		if (curl_errno($this->curl)) {
 			throw new \Exception(curl_error($this->curl)); 
		}  
 		return $this;
 	}   
  
 	 
 	  
}
