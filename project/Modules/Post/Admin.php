<?php
namespace Modules\Post;
use Controllers\BaseAdminAutoController;
use Model\Post as PostModel;
use Model\Category as CateModel;
class Admin extends BaseAdminAutoController{
	
	public $accessDeny = [
		'*'
	];
	public $obj;
	//跳转
	public $jump = 'post/admin/index';
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
	
	function indexAction(){
		if(isset($_GET['s'])){
			$condition['status'] = (int)$_GET['s'];
		}
		$q = trim($_GET['q']);
		if($q){
			$condition['$or'] = [ 
					['body'=> new \MongoRegex("/$q/i"),],
					['title'=>new \MongoRegex("/$q/i"),],
			];
		}
		
		
		$this->condition = $condition;
		
		return parent::indexAction();
	}
	
	function viewAction(){
		parent::viewAction();
		$obj = new CateModel;
		$this->data['category'] = $obj->getTree($this->data['data']->category);
		return $this->view($this->view,$this->data);
		
	}
	 
}