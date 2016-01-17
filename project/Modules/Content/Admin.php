<?php
namespace  Modules\Content;
use Controllers\BaseAdminAutoController;
class Admin extends BaseAdminAutoController {
	public $jump = 'admin/content/type';
	public $per_page = 10;
	public $sort = ['created'=>-1];
	public $condition = [];
	public $view = 'index';
	public $data = [];
	public $info = '操作已完成';
	public $disable = false;
	
	function init(){
		parent::init();
		$q = $_GET['q'];
		$model = "\Content\\$q";
		$this->obj = new $model;
		$this->data['fields'] = $this->obj->fields;
		$allowFields = [
				'title','status'
				
		];
		
		$int = [
			'status'
		];
		foreach($this->data['fields'] as $k=>$v){
			$allowFields[] = $k;
			if($v['int']===true){
				$int[] = $k;
			}
		}
		/**
		 * 允许保存到数据库的字段
		 * @var array $allowFields
		 */
		$this->obj->allowFields = $allowFields;
		
		$this->obj->int = $int;
		 
		$this->jump = url($this->jump,$_GET);
		
		$this->data['type'] = $this->obj->title;
	}
	
	
	function indexAction() {
 		return parent::indexAction();
	}
	
	function viewAction() {
		return parent::viewAction();
	}
	
	 
	
}