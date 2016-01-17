<?php
include __DIR__.'/Start.php';
include __DIR__.'/Config.php';



 $dir = __DIR__.'/route';
 $list = scandir($dir);
 foreach($list as $v){
 	if(substr($v,-4)=='.php'){
 		include $dir.'/'.$v;
 	}
 }