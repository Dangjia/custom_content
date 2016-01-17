<?php
namespace Model;
class Config extends Base{
	public $tb = 'config';
	public $tbVersion = "version_config";
	public $allowFields = [
		'title',
		'value',
		'status'
	];
	
	public $int = [
		 'status'
	];
	
	public $validate = [
		'title'  => 'required|unique(config,title)',
	];
	
	public $validateMessage = [
		'title'  => [
					'required'=>'配置名不能为空',
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
	
	function get($key){
		return $this->findOne(['title'=>$key])->value;	
	}
	
	
	
	
	 
	
	
	
}