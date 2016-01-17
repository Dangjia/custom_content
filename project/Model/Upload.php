<?php
namespace Model;

class Upload extends Base{
	public $tb = 'upload';
	
	public $allowFields = [
		'name',
		'extension',
		'mime',
		'size',
		'hash'
	];
	
	public $validate = [
		'name'  => 'required',
		'extension'  => 'required',
	];
	
	/*public $validateMessage = [
		'title'  => [
					'required'=>'标题不能为空',
				],
		'body'  => [
					'required'=>'内容不能为空',
			],
	];*/
	
	
	
 
	
}