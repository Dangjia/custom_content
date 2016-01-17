<?php
use Intervention\Image\ImageManagerStatic as Image;

function f_img_resize($path,$w,$h,$watermark = null){
	if(!$path){
		return;
	}
	//Image::configure(array('driver' => 'gd'));
	$path_0 = $path;
	if(!file_exists(WEB.$path_0)){
		return;
	}
	$path = str_replace('/upload/','/upload/thum/',$path);
	$new = file_dir($path);
	$ext = file_ext($path);
	$new = $new.'/'.file_name($path)."_$w_$h".'.'.$ext;
	if(file_exists(WEB.$new)){
		return $new;
	}
	echo WEB.$path_0;
	$img = Image::make(WEB.$path_0);
	$img->resize($w, $h);
	
	if(!is_dir(WEB.file_dir($new))){
		mkdir(WEB.$new ,0777 , true);
	}
	if($watermark){
		$img->insert(WEB.$watermark);
	}
	$img->save(WEB.$new);
	return $new;
}





function  theme_get_post($slug){
		$post = obj('Model\Post');
		$c['slug'] = $slug;
		return $post->findOne($c);

}