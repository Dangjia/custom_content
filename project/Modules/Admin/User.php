<?php
namespace Modules\Admin;
use Controllers\BaseAdminAutoController;
use Model\Login as Model;
class User extends BaseAdminAutoController{
	
	public $accessDeny = [
		'*'
	];
	public $obj;
	//跳转
	public $jump = 'admin/user/index';
	//分页
	public $per_page = 10;
	//列表页排序 
	public $sort = ['created'=>-1];
	//列表页查寻条件
	public $condition = [];
	//当前视图
	public $view = 'user';
	
	function init(){
		parent::init();
		$this->obj = new Model;
		
	}
	
	
	
	 
	
	 
}