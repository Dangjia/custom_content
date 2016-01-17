<?php
namespace Widget\Core;
/**
 *  http://silviomoreto.github.io/bootstrap-select/
 * 
 * @author SUN KANG
 *
 */
 
class BootstrapSelect extends Base{

	
	function run(){
			
	}
	
	
	function load(){
		$baseUrl = $this->asssets('bootstrap-select');
		 
		$this->scriptLink[] = $baseUrl.'dist/js/bootstrap-select.min.js';
		$this->cssLink[] = $baseUrl.'dist/css/bootstrap-select.min.css';
 		if(!$this->option){
			 $this->option = [
			 	'style'=>'btn-success'	,
			 ];
 		}
 		$op = $this->toJson($this->option);
		 $this->script[] = "$('.select').selectpicker(".$op.");";
		
	}
	
}

 