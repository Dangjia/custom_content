<?php
include __DIR__.'/Function-Core-System.php';
include __DIR__.'/Function-Core-Namespace.php';
include __DIR__.'/Function-Custom.php';


session_start();
ini_set('display_errors',1);
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
date_default_timezone_set('Asia/Shanghai');
Carbon\Carbon::setLocale('zh');


//echo $tomorrow = Carbon::now()->addDay()->diffForHumans();exit;
