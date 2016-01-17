<?php
use Carbon\Carbon;

get('/',function(){
	return view('index');
});
get('about',function(){
	return view('about');
});

get('guid',function(){
	
	 
	return view('guid');
});

get('posts|posts/<q:\w+>',function(){
	$post = new Model\Post;
	$q  = $_GET['q'];
	$c['status'] = 1;
	if($q){
		//$c['title'] =  new \MongoRegex("/$q/i");
		$obj = obj('Model\Category');
		$rt = $obj->findOne(['slug'=>$q]);
		$cid = $rt->id;
		if($cid){
			$c['category'] = $cid;
		}
	}
	if($q){
		$qurl = "/".$q;
	}
	$data = $post->page([
				'url'=>'/posts'.$qurl,
				'size'=>1,
				'sort'=>[
					'created'=>-1
				],
				'condition'=>$c,
		]);
	return view('posts',$data);

});


get('post/<id:\w+>',function($id){
	$post = new Model\Post;
	$data['data'] = $post->findOne(['slug'=>$id]);
	return view('posts_view',$data);
});

get_post('user','admin/login@index');