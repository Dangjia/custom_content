<?php 
namespace Widget\Core;
class Ckeditor extends Base{

	function run(){
		 

	}
	
	function load(){


		$baseUrl = $this->asssets('ckeditor');


		$this->scriptLink = [
				$baseUrl.'ckeditor.js',
				$baseUrl.'lang/zh-cn.js'
		];
		$this->script[] = "
			
			$('#submit').click(function(){
				$('#".$this->ele."').val(CKEDITOR.instances.".$this->ele.".getData());
			});
			CKEDITOR.replace( '".$this->ele."');
			 
		";
		
	}
	
}
