<?php
namespace Modules\Menu;
use Controllers\BaseAdminAutoController;
use Model\Menu as PostModel;
class Admin extends BaseAdminAutoController{
	
	public $accessDeny = [
		'*'
	];
	public $obj;
	//跳转
	public $jump = 'menu/admin/index';
	//分页
	public $per_page = 10;
	//列表页排序 
	public $sort = ['created'=>-1];
	//列表页查寻条件
	public $condition = [];
	//当前视图
	public $view = 'index';
	
	function init(){
		parent::init();
		$this->obj = new PostModel;
	}
	
	
	function viewAction(){
		parent::viewAction();
		$this->data['category'] = $this->obj->getTree($this->data['data']->pid);
		return $this->view($this->view,$this->data);
	}
	
	 
}