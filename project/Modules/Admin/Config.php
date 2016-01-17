<?php
namespace Modules\Admin;
use Controllers\BaseAdminAutoController;
use Model\Config as PostModel;
class Config extends BaseAdminAutoController{
	
	public $accessDeny = [
		'*'
	];
	public $obj;
	//跳转
	public $jump = 'admin/config/index';
	//分页
	public $per_page = 10;
	//列表页排序 
	public $sort = ['created'=>-1];
	//列表页查寻条件
	public $condition = [];
	//当前视图
	public $view = 'config';
	
	function init(){
		parent::init();
		$this->obj = new PostModel;
	}
	
	
	 
	
	 
}