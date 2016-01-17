<?php
namespace Widget\Core;
/**
 *  https://select2.github.io/
 * 
 * @author SUN KANG
 *
 */
 
class  Select2 extends Base{

	
	function run(){
			
	}
	
	
	function load(){
		$baseUrl = $this->asssets('select2');
		 
		$this->scriptLink[] = $baseUrl.'dist/js/select2.min.js';
		$this->cssLink[] = $baseUrl.'dist/css/select2.min.css';
 		if(!$this->option){
			 $this->option = [
			 	 
			 ];
 		}
 		$op = $this->toJson($this->option);
		$this->script[] = "
				$.fn.select2.defaults.set('theme', 'classic');
				$('.select').select2(".$op.");
		";
		
	}
	
}

 