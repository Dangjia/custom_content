<?php
namespace Model;
class Category extends Base{
	public $tb = 'category';
	public $tbVersion = "version_category";
	public $allowFields = [
		'title',
		'pid',
		'slug',
		'status'
	];
	
	public $int = [
		 'status'	
	];
	
	public $validate = [
		'title'  => 'required',
		'slug'  => 'required|unique(category,slug)',
	];
	
	public $validateMessage = [
		'title'  => [
					'required'=>'分类名不能为空',
				],
		'slug'  => [
				'required'=>'标识不能为空',
				'unique'=>'已存在标识',
		],
	];
	
	/**
	 * 记录VERSION
	 * @param unknown $data
	 * @param unknown $condition
	 */
	function beforeUpdate($data,$condition){
		$data = $this->filterData($data);
		$mo = mongo($this->tbVersion);
		if(!$data){
			return true;
		}
		foreach($data as $k=>$v){
			$mo->$k = $v;
		}
		$mo->nodeid = $condition['_id'];
		$mo->save();
		return true;
	}
	
	 
	
	 
	
	
	
}