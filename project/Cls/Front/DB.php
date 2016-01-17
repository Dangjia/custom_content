<?php
namespace Cls\Front;

class DB{
	
	function get_post($c = []){
		$post = obj('Model\Post');
		return $post->findOne($c);
	}
	
	
}