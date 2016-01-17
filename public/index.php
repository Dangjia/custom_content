<?php
$t1 = microtime(true);

require_once './../vendor/autoload.php';

use  sunkangchina\phprouter\Route as Route;

header("Content-type: text/html; charset=utf-8");
$time_start = microtime(true);
define('WEB',__DIR__);
define('BASE',realpath(__DIR__.'/../'));  
include __DIR__."/../Route.php"; 
try {  
     $view = Route::run(); 
     if($view){
         echo $view;
     }
}catch (Exception $e) {  
     var_dump($e->getMessage());	
} 

if(!is_ajax()){
	$t2 = microtime(true);
	echo "\n<!-- runtime:".round($t2-$t1,3)." s -->";
}
 
   