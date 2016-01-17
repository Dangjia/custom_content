<?php
namespace Cls;
class Str{
	/******************************************************************
	 * PHP截取UTF-8字符串，解决半字符问题。
	* 截取utf-8字符串，截取后，用 ...代替被截取的部分
	* $length 左边的子串的长度
	****************************************************************/
	function cut($string, $length) {
	    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info);
	    for($i=0; $i<count($info[0]); $i++) {
	        $wordscut .= $info[0][$i];
	        $j = ord($info[0][$i]) > 127 ? $j + 2 : $j + 1;
	        if ($j > $length - 3) {
	            return $wordscut." ...";
	        }
	    }
	    return join('', $info[0]);
	}
	 
	
}