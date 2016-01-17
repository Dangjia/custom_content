<?php
namespace Model;
class Menu extends Base{
	public $tb = 'menu';
	public $tbVersion = "version_menu";
	public $allowFields = [
		'title',
		'pid',
		'status',
		'slug',
		'sort'
	];
	
	public $int = [
		 'status','sort'	
	];
	
	public $validate = [
		'title'  => 'required',
		'slug'  => 'required|unique(menu,slug)',
	];
	
	public $validateMessage = [
		'title'  => [
					'required'=>'菜单名不能为空',
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