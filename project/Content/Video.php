<?php
namespace Content;
use Model\Base;
class Video extends Base{
	
	public $tb = 'video';
	//public $tbVersion = "version_video";
	
	public $title = "视频";

	 public $fields = [
	 	'title2'=>[
	 		'label'=>'标题2',
	 		'element'=>'txt',
	 		'int'=>false,
	 	],


	 ];
	 
	/**
	 * 验证规则 
	 * @var unknown
	 */
	public $validate = [
		'title'=>'required',
		'title2'=>'required',
		//'slug'=>'required|unique(posts,slug)',
	];
	/**
	 * 验证错误提示信息
	 * @var array $validateMessage
	 */
	public $validateMessage = [
		'title'  => [
					'required'=>'标题不能为空为',
				],
		/*'body'  => [
					'required'=>'内容不能为空',
			],
		'category'  => [
					'required'=>'请选择分类',
			],
		'slug'  => [
					'required'=>'url不能为空',
					'unique'=>'已存在设置的URL',
			],*/
	];
	
	
	
	
	
	 
	/**
	 * 记录VERSION
	 * @param unknown $data
	 * @param unknown $condition
	 */
	function beforeUpdate($data,$condition){
		if(!$this->tbVersion){
			return;
		}
		$data = $this->filterData($data);
		$mo = mongo($this->tbVersion);
		if(!$data){
			return true;
		}
		foreach($data as $k=>$v){
			$mo->$k = $v;
		}
		if(!$data['file']){
			$this->data['file'] = [];
		}
		 
		$mo->nodeid = $condition['_id'];
		$mo->save();
		return true;
	}
	





}