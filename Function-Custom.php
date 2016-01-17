<?php

theme('main_1');





$frontTheme = theme();
 

///////////////////////////////////////
// load theme function.php
///////////////////////////////////////


$frontThemeFunction = WEB.'/themes/'.$frontTheme.'/function.php';
if(file_exists($frontThemeFunction)){
	include $frontThemeFunction;
}






///////////////////////////////////////
// widget
///////////////////////////////////////
/**
 * 使用WIDGET
 * @param unknown $name
 * @param array $par
 */
function widget($name,$par = []){
	$core = "Widget\Core\Base";
	return $core::render($name,$par);
	
}
/**
 * 渲染WIDGET
 * 
 */
function widget_render(){
	$core = "Widget\Core\Base";
	$full = $core::$exists['_unique'];
	if(!$full){
		return;
	}
	foreach ($full as $obj){
		if($obj->scriptLink){
			foreach($obj->scriptLink as $v){
				$js .=  "<script type=\"text/javascript\" src='".$v."'></script>\n";
			}
		}
		if($obj->script){
			foreach($obj->script as $v){
				$jsCode .= $v."\n";
			}
		}
		
		if($obj->cssLink){
			foreach($obj->cssLink as $v){
				$css.="<link rel=\"stylesheet\" href=\"".$v."\">\n";
			}
		}
		if($obj->css){
			foreach($obj->css as $v){
				$cssCode .= $v."\n";
			}
		}
	
	}
	if($js){
		echo $js;
	}
	if($css){
		echo $css;
	}
	if($jsCode){
		$script = "<script type=\"text/javascript\">\n$(function(){\n";
		$script .=$jsCode;
		$script .="\n});\n</script>\n";
		echo $script;
	}
	
	if($cssCode){
		$script = "<style>\n";
		$script .= $cssCode;
		$script .="\n</style>\n";
		echo $script;
	}
	
	
	
}
