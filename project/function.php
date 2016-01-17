<?php

function hook_view($view){
	return $view;
}


function hook_pre_url($link){
	return '/';
}
