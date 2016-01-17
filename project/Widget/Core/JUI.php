<?php
namespace Widget\Core;
/**
 *  
 * 
 * @author SUN KANG
 *
 */
 
class JUI extends Base{

	
	function run(){
		 	
	}
	
	
	function load(){
		$baseUrl = $this->asssets('jquery-ui');
		$this->scriptLink[] = $baseUrl.'jquery-ui.min.js';
		$this->cssLink[] = $baseUrl.'jquery-ui.css';
		
	}
	
}

 