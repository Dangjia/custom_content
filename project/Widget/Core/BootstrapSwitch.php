<?php
namespace Widget\Core;
/**
 *  
 * 
 * @author SUN KANG
 *
 */
 
class BootstrapSwitch extends Base{

	
	function run(){
			
	}
	
	
	function load(){
		$baseUrl = $this->asssets('bootstrap-switch');
		 
		$this->scriptLink[] = $baseUrl.'dist/js/bootstrap-switch.js';
		$this->cssLink[] = $baseUrl.'dist/css/bootstrap3/bootstrap-switch.css';
 
		 
		 $this->script[] = "$(\".checkbox\").bootstrapSwitch();";
		
	}
	
}

 