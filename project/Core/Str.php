<?php   namespace Core;
/**
*  字符串操作 
*  
*  　　
* @author Sun <sunkang@wstaichi.com>
* @license 私有，代码仅限内部使用。
* @copyright  
* @time 2014-2015
*/
/**
*<code>
*字符串
* echo $v = Str::size(1024*10);  //返回　１0KB
* $v = '10 KB'; 中间必须有空格
* dump(Str::size_to($v,'mb'));exit;    0.01
*</code>
* 	  
*/
class Str
{ 
	static $size = ['B', 'KB', 'MB', 'GB', 'TB'];
	/**
	 * 生成不重复字符串　
	 *
	 * @link http://docs.mongodb.org/manual/reference/object-id/
	 * @return string 24 hexidecimal characters
	 */
	static function id()
	{
	    static $i = 0;
	    $i OR $i = mt_rand(1, 0x7FFFFF);
	 
	    return sprintf("%08x%06x%04x%06x",
	        /* 4-byte value representing the seconds since the Unix epoch. */
	        time() & 0xFFFFFFFF,
	 
	        /* 3-byte machine identifier.
	         *
	         * On windows, the max length is 256. Linux doesn't have a limit, but it
	         * will fill in the first 256 chars of hostname even if the actual
	         * hostname is longer.
	         *
	         * From the GNU manual:
	         * gethostname stores the beginning of the host name in name even if the
	         * host name won't entirely fit. For some purposes, a truncated host name
	         * is good enough. If it is, you can ignore the error code.
	         *
	         * crc32 will be better than Times33. */
	        crc32(substr((string)gethostname(), 0, 256)) >> 16 & 0xFFFFFF,
	 
	        /* 2-byte process id. */
	        getmypid() & 0xFFFF,
	 
	        /* 3-byte counter, starting with a random value. */
	        $i = $i > 0xFFFFFE ? 1 : $i + 1
	    );
	}  
	 
	/**
	* 生成不重复订单ID
	*/
	static function order_id($uid=null)
	{
		mt_srand((double) microtime() * 1000000);  
        return date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).$uid;   
	}
	/**
	* 折扣 100 1 0.1折
	* @param string $size 
	* @return string　 
	*/
    static function discount($price,$nowprice) 
	{
		  return round(10 / ($price / $nowprice), 1); 
	} 
	/**
	* 多少岁
	* @return string　 
	*/
    static function age($bornUnix) 
	{
		if(strpos($bornUnix,' ')!==false || strpos($bornUnix,'-')!==false){
			$bornUnix = strtotime($bornUnix); 
		}
		return ceil((time()-$bornUnix)/86400/365);	
	 	
	} 
	/**
	* 计算时间剩余　２天３小时２８分钟１０秒
	* 返回　　[d h m s]
	* @return string　 
	*/
    static function less_time($a ,$b = null) 
	{
			if(!$b) $time = $a;
			else $time = $a-$b;
			if($time<=0) return -1;
			$days = intval($time/86400);
			$remain = $time%86400;
			$hours = intval($remain/3600);
			$remain = $remain%3600;
			$mins = intval($remain/60);
			$secs = $remain%60;
			return ["d" => $days,"h" => $hours,"m" => $mins,"s" => $secs]; 
	} 
	/**
	* 点击链接 字段值加减到地址栏
	* @return string　 
	*/
	function url($type,$value){
		$mi = false;
		if(strpos($type,'[]')) {
			$type = str_replace('[]','',$type);
			$mi = true;
		}
		$get = $_GET;
		$v = $get[$type]; 
		if(is_array($v)){
			if(in_array($value,$v))
				unset($get[$type][array_search($value,$v)]);
			else{
				$get[$type][] = $value; 
			}
		}else{
			if($v == $value)
				unset($get[$type]);
			else{ 
				if(!$v && $mi==true) {
					$get[$type.'[]'] = $value; 
				}else{
					$get[$type] = $value; 
				}
			}
		} 
		return $get;
	}
	/**
	* 字节单位自动转换 显示1GB MB等
	* @param string $size 
	* @return string　 
	*/
    static function size($size) 
	{
		 $units = static::$size; 
		 for ($i = 0; $size >= 1024 && $i < 4; $i++) {
		 		$size /= 1024; 
		 }
		 return round($size, 2).' '.$units[$i]; 
	}
	/**
	* 字节单位自动转换到指定的单位
	* @param string $size 　 
	* @param string $to 　
	* @return string
	*/
	static function size_to($size,$to = 'GB'){
		 $size = strtoupper($size);
		 $to = strtoupper($to);
		 $arr = explode(' ',$size);
		 $key = $arr[1];
		 $size = $arr[0]; 
		 $i = array_search($key,static::$size);
		 $e = array_search($to,static::$size);
		 $x = 1;
		 if($i < $e ){
			 for($i;$i<$e;$i++){
				$x *= 1024;
			 }  
			 return round($size/$x,2); 
		 }
		 for($e;$e<$i;$e++){
			$x *= 1024;
		 }  
		 return $size*$x; 
	} 
    
	/**
	* 截取字符串 可以截取中文
	* @param string $str 　 
	* @param string $length 　
	* @param string $ext 　
	* @return string
	*/
	static function cut($str, $length,$ext='...') {
		$str = trim(strip_tags($str));
		global $s;
		$i = 0;
		$len = 0;
		$slen = strlen($str);
		$s = $str;
		$f = true; 
		while ($i <= $slen) {
			if (ord($str{$i}) < 0x80) {
				$len++; $i++;
			} 
			else if (ord($str{$i}) < 0xe0) {
				$len++; $i += 2;
			} 
			else if (ord($str{$i}) < 0xf0) {
				$len += 2; $i += 3;
			} 
			else if (ord($str{$i}) < 0xf8) {
				$len += 1; $i += 4;
			} 
			else if (ord($str{$i}) < 0xfc) {
				$len += 1; $i += 5;
			} 
			else if (ord($str{$i}) < 0xfe) {
				$len += 1; $i += 6;
			}

			if (($len >= $length - 1) && $f) {
				$s = substr($str, 0, $i);
				$f = false;
			}

			if (($len > $length) && ($i < $slen)) {
				$s = $s . $ext; break;  
			}
		}
		return $s;
	}
	/**
	* 随机数字
	* @param string $j 位数 　 
	* @return nubmer
	*/
	function rand2($j = 4 ){
		$str = null;
		for($i=0;$i<$j;$i++){
			$str .= mt_rand(0,9);
		}
		return $str;
	} 
    /**
	* 随机字符
	* @param string $j 位数 　 
	* @return string
	*/
	function rand($j = 8){
		$string = "";
	    for($i=0;$i < $j;$i++){
	        srand((double)microtime()*1234567);
	        $x = mt_rand(0,2);
	        switch($x){
	            case 0:$string.= chr(mt_rand(97,122));break;
	            case 1:$string.= chr(mt_rand(65,90));break;
	            case 2:$string.= chr(mt_rand(48,57));break;
	        }
	    }
		return strtoupper($string); //to uppercase
	}
	/**
	* 组织URL query string,没有问号的
	* @param array $arr 
	* @return string		
	*/
	function query_build($arr = []){
		if(!is_array($arr) || !implode('',$arr)) return;
		foreach($arr as $k=>$v){
			$str .="$k=$v&";
		}
		return substr($str,0,-1);
	}
	/**
	* 保存cookie或session,数组或字符串全转成字符串		
	*/
	static function cookie($arr){
		if(is_object($arr)){
			$arr = (array)$arr;
		}
		if(is_array($arr)){
			foreach($arr as $k=>$v){
				if(is_object($v) || ($v instanceof Closure) ){
			 		$v =  call_user_func_array ($v,[]);
			 	}
			 	$new[$k] = $v;
		 	}
		 	$arr = $new;
	 	}
		 if(is_array($arr)){
		 	 $str = base64_encode(serialize($arr));
		 }else{
		 	$str  = base64_encode($arr);
		 }
		 return $str;
	}
	/**
	* 取得cookie或session
	*/
	static function re_cookie($str){
		 $str  = base64_decode($str);
		 if(static::is_serialized($str)){
		 	$str = static::maybe_unserialize($str);
		 }
		 return $str;
	}
	 /***********************************************************************************************/
	 /**
	 * 以下全英文注释代码来自　
	 * @link https://github.com/brandonwamboldt/utilphp/blob/master/src/utilphp/util.php
	 * 对字符串数组操作很实用
	 */
	 /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     * @link https://github.com/brandonwamboldt/utilphp/blob/master/src/utilphp/util.php
     * @param  mixed $data Value to check to see if was serialized
     * @return boolean
     */
    static function is_serialized($data)
    {
        // If it isn't a string, it isn't serialized
        if (!is_string($data)) {
            return false;
        }
        $data = trim($data);
        // Is it the serialized NULL value?
        if ($data === 'N;') {
            return true;
        }
        // Is it a serialized boolean?
        elseif ($data === 'b:0;' || $data === 'b:1;') {
            return true;
        }
        $length = strlen($data);
        // Check some basic requirements of all serialized strings
        if ($length < 4 || $data[1] !== ':' || ($data[$length - 1] !== ';' && $data[$length - 1] !== '}')) {
            return false;
        }
        return @unserialize($data) !== false;
    }
     /**
     * Unserialize value only if it is serialized.
     * @link https://github.com/brandonwamboldt/utilphp/blob/master/src/utilphp/util.php
     * @param  string $data A variable that may or may not be serialized
     * @return mixed
     */
    static function maybe_unserialize($data)
    {
        // If it isn't a string, it isn't serialized
        if (!is_string($data)) {
            return $data;
        }
        $data = trim($data);
        // Is it the serialized NULL value?
        if ($data === 'N;') {
            return null;
        }
        $length = strlen($data);
        // Check some basic requirements of all serialized strings
        if ($length < 4 || $data[1] !== ':' || ($data[$length - 1] !== ';' && $data[$length - 1] !== '}')) {
            return $data;
        }
        // $data is the serialized false value
        if ($data === 'b:0;') {
            return false;
        }
        // Don't attempt to unserialize data that isn't serialized
        $uns = @unserialize($data);
        // Data failed to unserialize?
        if ($uns === false) {
            $uns = @unserialize(static::fix_broken_serialization($data));
            if ($uns === false) {
                return $data;
            } else {
                return $uns;
            }
        } else {
            return $uns;
        }
    }
    /**
     * Unserializes partially-corrupted arrays that occur sometimes. Addresses
     * specifically the `unserialize(): Error at offset xxx of yyy bytes` error.
     *
     * NOTE: This error can *frequently* occur with mismatched character sets
     * and higher-than-ASCII characters.
     *
     * Contributed by Theodore R. Smith of PHP Experts, Inc. <http://www.phpexperts.pro/>
     * @link https://github.com/brandonwamboldt/utilphp/blob/master/src/utilphp/util.php
     * @param  string $brokenSerializedData
     * @return string
     */
     static function fix_broken_serialization($brokenSerializedData)
    {
        $fixdSerializedData = preg_replace_callback('!s:(\d+):"(.*?)";!', function($matches) {
            $snip = $matches[2];
            return 's:' . strlen($snip) . ':"' . $snip . '";';
        }, $brokenSerializedData);
        return $fixdSerializedData;
    }
	/**
     * Checks to see if the page is being server over SSL or not
     *
     * @return boolean
     */
    public static function is_https()
    {
        return isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
    }
 
}
