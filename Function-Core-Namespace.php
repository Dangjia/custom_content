<?php

///////////////////////////////////////
// project/Core
// Core部分类
///////////////////////////////////////
use Core\Cookie;
use Core\Session;
use Core\Crypt;
use Core\Config;
function config($name,$value = null){
	if(!$value){
		return Config::get($name);
	}
	Config::set($name,$value);
}



//$name string
function cookie($name = null,$value = null,$expire = 0){
	if($value){
		return Cookie::set($name,$value,$expire);
	}
	return Cookie::get($name);
}
//$name string|array
function cookie_delete($name){
	return Cookie::delete($name);
}

//$name string
function session($name,$value = null){
	if($value){
		return Session::set($name,$value);
	}
	return Session::get($name);
}
//$name string|array
function session_delete($name){
	return Session::delete($name);
}

function flash($name,$value = null){
	return Session::flash($name,$value);
}

function has_flash($name){
	return Session::has_flash($name);
}

function encode($value,$key = null){
	$c = new Crypt;
	if($key){
		$par['key'] = $key;
	}
	return $c->encode($value,$par);
}

function decode($value,$key = null){
	$c = new Crypt;
	if($key){
		$par['key'] = $key;
	}
	return $c->decode($value,$par);
}






