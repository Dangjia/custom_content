<?php
namespace  Cls;
class Plat{
	
	function is_weixin(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}
		return false;
	
	}
	
	function is_android(){
		if ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'android') !== false ) {
			return true;
		}
		return false;
	}
	
	function is_iphone(){
		if ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone') !== false ) {
			return true;
		}
		return false;
	}
	
	function is_ipad(){
		if ( strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'ipad') !== false ) {
			return true;
		}
		return false;
	}
	
	
}