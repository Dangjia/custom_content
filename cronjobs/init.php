<?php

require_once './vendor/autoload.php';
use  sunkangchina\phprouter\Route as Route;
header("Content-type: text/html; charset=utf-8");
define('WEB',realpath(__DIR__.'/../public/'));
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
 