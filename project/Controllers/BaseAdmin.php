<?php
namespace Controllers;
use Cls\Comm;
class BaseAdmin extends Base  {
	  
	 public $obj;
	 public $loginUrl = "/admin/login/index";
	 
	 function init(){
	 	parent::init();
	 	view_minify(Comm::config('admin_minify')?:false);
	 	$t = $_GET['AdminThemeTryChange'];
	 	$t1 = Comm::config('admin_theme');
	 	if($t){
	 		$t1 = $t;
	 	}
	 	theme($t1?:'admin');
	 }
	 
	 function _check(){
	 	return cookie('adminId');
	 }
	 
	 
}
